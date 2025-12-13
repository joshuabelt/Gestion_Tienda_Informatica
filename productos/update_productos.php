<?php
include('../connection.php');
$con = connection();

// Verificar si se recibió el ID
if (!isset($_GET['id'])) {
    header("Location: productos.php");
    exit();
}

$id = mysqli_real_escape_string($con, $_GET['id']);
$sql = "SELECT * FROM productos WHERE id_producto='$id'";
$query = mysqli_query($con, $sql);

// Verificar si la consulta fue exitosa
if (!$query) {
    die("Error en la consulta: " . mysqli_error($con));
}

$row = mysqli_fetch_assoc($query);

// Verificar si se encontró el producto
if (!$row) {
    die("Producto no encontrado");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar productos</title>
    <link rel="stylesheet" href= "../styles/update.css"></link>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .form-container { max-width: 600px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        h1 { margin-top: 0; }
        input[type="text"] { width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 4px; }
        input[type="submit"] { background-color: #2196F3; color: white; padding: 10px 15px; border: none; border-radius: 4px; cursor: pointer; }
        input[type="submit"]:hover { background-color: #0b7dda; }
        a[type="button"]{ background-color: red; color: white}
        .btn-cancel {
         background-color: #f44336;
         color: white;
         padding: 10px 15px;
         border-radius: 4px;
         text-decoration: none;
         display: inline-block;
}
.btn-cancel:hover {
    background-color: #c62828;
}
.radio-group label {
    display: block;
    margin-bottom: 5px;
} </style>
</head>
<body>
  <div class="form-container">
    <form action="editproductos.php" method="POST">
      <h1>Editar Productos</h1>
      <label>Id Producto</label><input type="text" name="id_producto" pattern="[A-Za-zÁ-Úá-úÑñ0-9 ]+" value="<?= htmlspecialchars($row['id_producto']) ?>" title="Solo números" required>   
      <label>Producto</label><input type="text" name="producto" placeholder="Producto" pattern="[A-Za-zÁ-Úá-úÑñ0-9 ]+"
       title="Solo letras" value="<?= htmlspecialchars($row['producto']) ?>" required>
      <label>Modelo</label><input type="text" name="modelo" placeholder="Modelo" pattern="[A-Za-zÁ-Úá-úÑñ0-9 ]+" 
       title="Solo letras" value="<?= htmlspecialchars($row['modelo']) ?>" required>
      <label>Descripción corta</label><input type="text" name="descrip_corta" placeholder="Descripción corta" pattern="[A-Za-zÁ-Úá-úÑñ0-9 .,\-&]+" 
       title="Solo letras, números, puntos, comas, guiones y &" value="<?= htmlspecialchars($row['descrip_corta']) ?>" required>
      <label>Descripción larga</label><textarea name = "descrip_larga" placeholder = "Descripción larga" pattern="[A-Za-zÁ-Úá-úÑñ0-9 .,\-&]+" 
       title="Solo letras, números, puntos, comas, guiones y &" rows="3" value="<?= htmlspecialchars($row['descrip_larga']) ?>" required></textarea>
      <label>Precio compra</label><input type="number" step="0.01" name="precio_compra" placeholder="Precio compra" onkeydown="return event.keyCode !== 69 && event.keyCode !== 187 && event.keyCode !== 189 && event.keyCode !== 190"
        value="<?= htmlspecialchars($row['precio_compra']) ?>" required>
      <label>Precio venta</label><input type="number" step="0.01" name="precio_venta" placeholder="Precio venta" onkeydown="return event.keyCode !== 69 && event.keyCode !== 187 && event.keyCode !== 189 && event.keyCode !== 190"
       value="<?= htmlspecialchars($row['precio_venta']) ?>" required>
      <label>Stock</label><input type="text" name="stock" placeholder="Stock" pattern="[0-9]+" title="Solo números" value="<?= htmlspecialchars($row['stock']) ?>" required>
      <label>Garantía</label><input type="text" name="garantia" placeholder="Garantia" pattern="[0-9]+" title="Solo números" value="<?= htmlspecialchars($row['garantia']) ?>" required>

      <input type="submit" value="Actualizar información">
      <a class="btn-cancel" href="productos.php" style="margin-left: 10px;">Cancelar</a>
    </form>
  </div>
</body>
</html>