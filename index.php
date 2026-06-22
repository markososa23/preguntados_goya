<?php
session_start();
// session_destroy();

include("admin/funciones.php");

aumentarVisita();

if (isset($_GET['reiniciar'])) {
    unset(
        $_SESSION['correctas'],
        $_SESSION['incorrectas'],
        $_SESSION['score'],
        $_SESSION['respondio'],
        $_SESSION['respuesta_elegida'],
        $_SESSION['respuesta_fue_correcta'],
        $_SESSION['respuesta_correcta'],
        $_SESSION['preguntaActualId'],
        $_SESSION['numPreguntaActual'],
        $_SESSION['preguntas'],
        $_SESSION['idPreguntas'],
        $_SESSION['idCategoria'],
        $_SESSION['nombreCategoria']
    );
}

if (isset($_GET['idCategoria'])) {
    $_SESSION['usuario'] = "usuario";
    $_SESSION['idCategoria'] = $_GET['idCategoria'];
    header("Location: jugar.php");
    exit;
}

$categoriasArray = [
    [
        "id" => 1,
        "nombre" => "Goya Futura",
        "letra" => "F"
    ],
    [
        "id" => 2,
        "nombre" => "Goya Historia",
        "letra" => "H"
    ],
    [
        "id" => 3,
        "nombre" => "Goya Escuelas",
        "letra" => "E"
    ],
    [
        "id" => 4,
        "nombre" => "Goya Ambiente",
        "letra" => "A"
    ],
    [
        "id" => 8,
        "nombre" => "Educación",
        "letra" => "ED"
    ]
];

$totalCategorias = count($categoriasArray);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link 
        rel="stylesheet" 
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" 
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g==" 
        crossorigin="anonymous" 
        referrerpolicy="no-referrer"
    />

    <link rel="stylesheet" href="estilo.css">

    <title>ITG GAME</title>
</head>

<body>
    <div class="container" id="container">
        <div class="left">
            <div class="logo"></div>

            <h2>PON A PRUEBA TUS CONOCIMIENTOS!!</h2>
        </div>

        <div class="right">
            <h2>Gir&aacute; la ruleta</h2>

            <div class="ruleta-box">
                <div class="puntero-ruleta"></div>

                <div id="ruleta" class="ruleta-goya">
                    <?php foreach ($categoriasArray as $index => $cat): ?>
                        <?php
                            $angulo = $index * (360 / $totalCategorias);
                        ?>

                        <span 
                            class="letra-ruleta"
                            style="transform: translate(-50%, -50%) rotate(<?php echo $angulo; ?>deg) translateY(-95px) rotate(-<?php echo $angulo; ?>deg);"
                        >
                            <?php echo htmlspecialchars($cat["letra"]); ?>
                        </span>
                    <?php endforeach; ?>
                </div>
            </div>

            <button id="botonGirarRuleta" class="boton-ruleta">
                Girar
            </button>

            <p id="resultadoRuleta" class="resultado-ruleta">
                Toc&aacute; girar para comenzar
            </p>

            <button id="botonContinuarRuleta" class="boton-ruleta oculto" disabled>
                Siguiente
            </button>

            <script>
                const categoriasRuleta = <?php echo json_encode($categoriasArray, JSON_UNESCAPED_UNICODE); ?>;
            </script>

            <script src="ruleta.js"></script>
        </div>
    </div>
</body>
</html>
