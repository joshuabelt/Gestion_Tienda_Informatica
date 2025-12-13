<?php 
 include('connection.php');

 $con = connection();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión Tienda</title>
    <link rel="stylesheet" href="styles/gestionTienda.css">
    <style>
     .inicio-button-container {
      text-align: center;
      margin: 30px 0;
      padding: 20px;
      width: 100%;
     }
     .btn-back {
      background-color: #6c757d;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            font-size: 16px;
            display: inline-block;
            transition: all 0.3s ease;
        }
        .btn-back:hover {
            background-color: #5a6268;
        }
    </style>
</head>
<body>
 <div class="container-general">
  <div class="container-1">
   <div class="proveedores">
    <h3 class="titulo-seccion">Proveedores</h3>
    <img class="proveedor-img" src="imagenes/proveedores.jpg">
    <button id="gestProveedores" class="boton">Gestionar</button>
   </div>  
   <div class="productos">
    <h3 class="titulo-seccion">Productos</h3>
    <img class="producto-img" src="imagenes/productos.jpg">
    <button id="gestProductos" class="boton">Gestionar</button>
   </div>
  </div>
  <div class="container-2">
   <div class="clientes">
    <h3 class="titulo-seccion">Clientes</h3>
    <img class="cliente-img" src="imagenes/clientes.png">
    <button id="gestClientes" class="boton">Gestionar</button>
   </div>
  </div>
  <div class= "inicio-button-container">
    <a href="index.php" class="btn-back">Volver al Inicio</a>
  </div>
 </div>
<script>
   document.getElementById('gestProveedores').addEventListener('click', function() {
    window.location.href = 'proveedores/proveedores.php';
   });
    document.getElementById('gestProductos').addEventListener('click', function() {
    window.location.href = 'productos/productos.php';
   });
    document.getElementById('gestClientes').addEventListener('click', function() {
    window.location.href = 'clientes/clientes.php';
   });
</script>
</body>
</html>