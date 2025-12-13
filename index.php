<?php 
 include('connection.php');

 $con = connection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página bienvenida Tienda Informática</title>
    <link rel="stylesheet" href ="styles/index.css">
</head>
<body>
  <h1>Bienvenido al Sistema de Gestión de DevTech</h1>
  <p>Nuestra misión es llevar la más alta tecnología a las manos de nuestros clientes</p> 
  <div class="caja">
   <img class="compu" src="imagenes/laptop1.jpg">
  </div>
  <div class="button-container">
   <button id="boton">Ingresar</button>
  </div>
  <script>
    document.getElementById('boton').addEventListener('click', function() {
    window.location.href = 'gestionTienda.php';
   });
  </script>
</body>
</html>