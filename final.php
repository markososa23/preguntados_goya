<?php
session_start();


//Si el usuario no esta logeado lo enviamos al index
if (!$_SESSION['usuario']) {
    header("Location:index.php");
}
//Aumentamos la estadistica
include("admin/funciones.php");
aumentarCompletados();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" charset="utf-8"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/easy-pie-chart/2.1.6/jquery.easypiechart.min.js" charset="utf-8"></script>
    <link rel="stylesheet" href="estilo.css">
    <title>ITG GAME</title>
</head>
<body>

    <div class="container-final" id="container-final">
        <div class="info">
            <h2>RESULTADO FINAL</h2>
            <div class="estadistica">
                <div class="acierto">
                    <span class="correctas numero"><?php echo $_SESSION['correctas'] ?? 0; ?></span>
                    CORRECTAS
                </div>
            </div>
            <div class="score">
                <div class="box">
                    <div class="chart" data-percent="<?php echo $_SESSION['score'] ?? 0; ?>">
                       <?php echo $_SESSION['score'] ?? 0; ?>%
                    </div>
                    <style>


    </style>
                    <!-- <h2>Escanea el QR para ver el ganador</h2>
                        <div class="qr"></div> -->
      
                                        
</div> 
<a href="index.php?reiniciar=1" class="boton-estilizado">Volver a intentar</a>  
    <script src="juego.js"></script>
</body>
</html>
