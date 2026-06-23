<?php
    session_start();

    if (!isset($_SESSION['usuarioLogeado'])) {
        header("Location:login.php");
        exit;
    }

    include("conexion.php");
    $id = $_GET['idPregunta'];

    $query = "DELETE FROM preguntas WHERE id = '$id'";
    mysqli_query($conn, $query);
    header("Location:listadopreguntas.php");
    exit;
?>
