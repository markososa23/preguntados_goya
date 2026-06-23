<?php
session_start();

if (!isset($_SESSION['usuario']) || !isset($_SESSION['idCategoria'])) {
    header("Location:index.php");
    exit;
}

include("admin/funciones.php");

$confi = obtenerConfiguracion();
$totalPreguntasPorJuego = max(1, (int) $confi['totalPreguntas']);

if (isset($_GET['siguiente'])) {
    // Ya respondió una pregunta
    $respuestaElegida = $_GET['respuesta'] ?? null;
    $respuestaCorrecta = $_SESSION['respuesta_correcta'] ?? null;
    $opcionesValidas = ['A', 'B', 'C', 'D', 'TIEMPO_AGOTADO'];

    if (!in_array($respuestaElegida, $opcionesValidas, true)) {
        header("Location:index.php");
        exit;
    }

    $tiempoAgotado = $respuestaElegida === 'TIEMPO_AGOTADO'
        || microtime(true) >= ($_SESSION['limite_respuesta'] ?? 0);

    if ($tiempoAgotado) {
        $respuestaElegida = 'TIEMPO_AGOTADO';
    }

    if ($respuestaElegida === null || $respuestaCorrecta === null || !isset($_SESSION['preguntaActualId'])) {
        header("Location:index.php");
        exit;
    }

    // Una recarga no debe volver a contabilizar la misma respuesta.
    if (!isset($_SESSION['respondio']) || $_SESSION['respondio'] !== true) {
        aumentarRespondidas();

        $_SESSION['respondio'] = true;
        $_SESSION['respuesta_elegida'] = $respuestaElegida;
        $_SESSION['tiempo_agotado'] = $tiempoAgotado;

        if (!$tiempoAgotado && $respuestaCorrecta == $respuestaElegida) {
            $_SESSION['respuesta_fue_correcta'] = true;
            $_SESSION['correctas'] = min(
                ($_SESSION['correctas'] ?? 0) + 1,
                $totalPreguntasPorJuego
            );
        } else {
            $_SESSION['respuesta_fue_correcta'] = false;
            $_SESSION['incorrectas'] = 1;
        }
    }

    $preguntaActual = obtenerPreguntaPorId($_SESSION['preguntaActualId']);

    if (!$preguntaActual) {
        header("Location:index.php");
        exit;
    }

} else {
    // Comenzó una nueva pregunta desde la ruleta

    if (!isset($_SESSION['correctas'])) {
        $_SESSION['correctas'] = 0;
    }

    // Nunca se muestra una pregunta adicional después de completar la décima.
    if ($_SESSION['correctas'] >= $totalPreguntasPorJuego) {
        $_SESSION['correctas'] = $totalPreguntasPorJuego;
        $_SESSION['score'] = 100;
        $_SESSION['incorrectas'] = 0;
        $_SESSION['partida_finalizada'] = true;
        header("Location: final.php");
        exit;
    }

    $_SESSION['respondio'] = false;
    $_SESSION['respuesta_elegida'] = null;
    $_SESSION['respuesta_fue_correcta'] = null;
    $_SESSION['tiempo_agotado'] = false;

    $_SESSION['numPreguntaActual'] = $_SESSION['correctas'];

    $_SESSION['preguntas'] = obtenerIdsPreguntasPorCategoria($_SESSION['idCategoria']);
    $_SESSION['idPreguntas'] = array();

    foreach ($_SESSION['preguntas'] as $idPregunta) {
        array_push($_SESSION['idPreguntas'], $idPregunta['id']);
    }

    if (count($_SESSION['idPreguntas']) === 0) {
        $_SESSION['incorrectas'] = 1;
        $_SESSION['correctas'] = 0;
        $_SESSION['nombreCategoria'] = obtenerNombreTema($_SESSION['idCategoria']);
        $_SESSION['score'] = 0;
        $_SESSION['partida_finalizada'] = true;
        header("Location: final.php");
        exit;
    }

    if (!isset($_SESSION['preguntasUsadas'])) {
        $_SESSION['preguntasUsadas'] = array();
    }

    $idsDisponibles = array_values(array_diff(
        $_SESSION['idPreguntas'],
        $_SESSION['preguntasUsadas']
    ));

    // Si ya salieron todas las preguntas de la categoría, vuelve a habilitarlas.
    if (count($idsDisponibles) === 0) {
        $idsDisponibles = $_SESSION['idPreguntas'];
        $_SESSION['preguntasUsadas'] = array_values(array_diff(
            $_SESSION['preguntasUsadas'],
            $_SESSION['idPreguntas']
        ));
    }

    shuffle($idsDisponibles);

    $preguntaActual = obtenerPreguntaPorId($idsDisponibles[0]);

    if (!$preguntaActual) {
        $_SESSION['incorrectas'] = 1;
        $_SESSION['correctas'] = 0;
        $_SESSION['nombreCategoria'] = obtenerNombreTema($_SESSION['idCategoria']);
        $_SESSION['score'] = 0;
        $_SESSION['partida_finalizada'] = true;
        header("Location: final.php");
        exit;
    }

    $_SESSION['preguntaActualId'] = $preguntaActual['id'];
    $_SESSION['respuesta_correcta'] = $preguntaActual['correcta'];
    $_SESSION['preguntasUsadas'][] = $preguntaActual['id'];
    $_SESSION['limite_respuesta'] = microtime(true) + 10;
}

function claseRespuesta($opcion, $respuestaElegida, $respuestaCorrecta, $respondio) {
    if (!$respondio) {
        return "";
    }

    if ($opcion == $respuestaCorrecta) {
        return "respuesta-correcta";
    }

    if ($opcion == $respuestaElegida && $opcion != $respuestaCorrecta) {
        return "respuesta-incorrecta";
    }

    return "respuesta-bloqueada";
}

$respondio = isset($_SESSION['respondio']) && $_SESSION['respondio'] === true;
$respuestaElegida = $_SESSION['respuesta_elegida'] ?? null;
$respuestaCorrecta = $_SESSION['respuesta_correcta'] ?? null;
$fueCorrecta = $_SESSION['respuesta_fue_correcta'] ?? null;
$tiempoAgotado = $_SESSION['tiempo_agotado'] ?? false;
$tiempoRestante = $respondio
    ? 0
    : max(0, (int) round((($_SESSION['limite_respuesta'] ?? microtime(true)) - microtime(true)) * 1000));
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>ITG GAME</title>

    <link rel="stylesheet" href="estilo.css">
</head>

<body>
    <div class="container-juego" id="container-juego">
        <header class="header">
            <div class="categoria">
                <?php echo obtenerNombreTema($preguntaActual['tema']); ?>
            </div>

            <a href="index.php?reiniciar=1">REINICIAR</a>
        </header>

        <div class="info">
            <div class="estadoPregunta">
                Pregunta 
                <span class="numPregunta">
                    <?php echo ($_SESSION['numPreguntaActual'] ?? 0) + 1; ?>
                </span> 
                de <?php echo $totalPreguntasPorJuego; ?>
            </div>

            <?php if (!$respondio): ?>
                <div class="temporizador" id="temporizador" role="timer" aria-live="polite">
                    <div class="temporizador-info">
                        <span>Tiempo</span>
                        <strong><span id="segundosRestantes">10</span> s</strong>
                    </div>
                    <div class="temporizador-barra" aria-hidden="true">
                        <span id="progresoTiempo"></span>
                    </div>
                </div>
            <?php endif; ?>

            <h3>
                <?php echo $preguntaActual['pregunta']; ?>
            </h3>

            <form
                action="<?php echo $_SERVER['PHP_SELF']; ?>"
                method="get"
                id="formPregunta"
                data-respuesta-correcta="<?php echo htmlspecialchars($respuestaCorrecta ?? '', ENT_QUOTES, 'UTF-8'); ?>"
                data-tiempo-restante="<?php echo $tiempoRestante; ?>"
            >
                <div class="opciones<?php echo $respondio ? ' respondida' : ''; ?>">
                    <label 
                        for="respuesta1" 
                        onclick="<?php echo $respondio ? '' : "responder(this, 'respuesta1')"; ?>" 
                        data-opcion="A"
                        class="op1 <?php echo claseRespuesta('A', $respuestaElegida, $respuestaCorrecta, $respondio); ?>"
                    >
                        <p><?php echo $preguntaActual['opcion_a']; ?></p>
                        <input type="radio" name="respuesta" value="A" id="respuesta1" required>
                    </label>

                    <label 
                        for="respuesta2" 
                        onclick="<?php echo $respondio ? '' : "responder(this, 'respuesta2')"; ?>" 
                        data-opcion="B"
                        class="op2 <?php echo claseRespuesta('B', $respuestaElegida, $respuestaCorrecta, $respondio); ?>"
                    >
                        <p><?php echo $preguntaActual['opcion_b']; ?></p>
                        <input type="radio" name="respuesta" value="B" id="respuesta2" required>
                    </label>

                    <label 
                        for="respuesta3" 
                        onclick="<?php echo $respondio ? '' : "responder(this, 'respuesta3')"; ?>" 
                        data-opcion="C"
                        class="op3 <?php echo claseRespuesta('C', $respuestaElegida, $respuestaCorrecta, $respondio); ?>"
                    >
                        <p><?php echo $preguntaActual['opcion_c']; ?></p>
                        <input type="radio" name="respuesta" value="C" id="respuesta3" required>
                    </label>

                    <label 
                        for="respuesta4" 
                        onclick="<?php echo $respondio ? '' : "responder(this, 'respuesta4')"; ?>" 
                        data-opcion="D"
                        class="op4 <?php echo claseRespuesta('D', $respuestaElegida, $respuestaCorrecta, $respondio); ?>"
                    >
                        <p><?php echo $preguntaActual['opcion_d']; ?></p>
                        <input type="radio" name="respuesta" value="D" id="respuesta4" required>
                    </label>
                </div>

                <?php if (!$respondio): ?>
                    <input type="hidden" name="siguiente" value="1">
                <?php endif; ?>
            </form>

            <?php if ($respondio): ?>
                <div class="resultado-respuesta">
                    <?php if ($fueCorrecta): ?>
                        <p>¡Correcto!</p>
                    <?php elseif ($tiempoAgotado): ?>
                        <p>
                            La respuesta correcta era:
                            <?php echo $respuestaCorrecta; ?>
                        </p>
                        <p class="mensaje-tiempo-agotado">Te quedaste sin tiempo</p>
                    <?php else: ?>
                        <p>
                            Incorrecto. La respuesta correcta era: 
                            <?php echo $respuestaCorrecta; ?>
                        </p>
                    <?php endif; ?>

                    <a class="boton-siguiente" href="continuar.php">
                        Siguiente
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="juego.js"></script>
</body>
</html>
