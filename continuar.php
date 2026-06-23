<?php
session_start();

include("admin/funciones.php");

$confi = obtenerConfiguracion();
$totalPreguntasPorJuego = max(1, (int) $confi['totalPreguntas']);

if (!isset($_SESSION['usuario'])) {
    header("Location: index.php");
    exit;
}

if (!isset($_SESSION['respuesta_fue_correcta'])) {
    header("Location: index.php");
    exit;
}

$correctas = min((int) ($_SESSION['correctas'] ?? 0), $totalPreguntasPorJuego);
$_SESSION['correctas'] = $correctas;
$_SESSION['score'] = (int) round(($correctas * 100) / $totalPreguntasPorJuego);

if ($_SESSION['respuesta_fue_correcta']) {

    if ($correctas >= $totalPreguntasPorJuego) {
        $_SESSION['incorrectas'] = 0;
        $_SESSION['nombreCategoria'] = "Todas";
        $_SESSION['partida_finalizada'] = true;
        header("Location: final.php");
        exit;
    }

    $_SESSION['respondio'] = false;
    $_SESSION['respuesta_elegida'] = null;
    $_SESSION['respuesta_fue_correcta'] = null;
    $_SESSION['tiempo_agotado'] = false;
    $_SESSION['preguntaActualId'] = null;
    $_SESSION['respuesta_correcta'] = null;
    $_SESSION['limite_respuesta'] = null;

    header("Location: index.php");
    exit;

} else {

    $_SESSION['incorrectas'] = 1;
    $_SESSION['partida_finalizada'] = true;
    $_SESSION['nombreCategoria'] = obtenerNombreTema($_SESSION['idCategoria']);
    header("Location: final.php");
    exit;
}
