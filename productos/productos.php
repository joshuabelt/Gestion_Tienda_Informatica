<?php 
 include('../connection.php');

 $con = connection();
 $sql2 = "SELECT * FROM productos";

 $query2 = mysqli_query($con, $sql2);

if (!$query2) {
    die("Error en consulta de productos: " . mysqli_error($con));
}

if (isset($_GET['delete_success'])) {
    $message = "";
    if ($_GET['delete_success'] == 2) {
        $message = "Producto eliminado correctamente";
    }  
    echo "<div style='background-color: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 4px;'>
            {$message}
            <span style='float: right; cursor: pointer;' onclick='this.parentElement.style.display=\"none\"'>×</span>
          </div>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv = "X-UA-Compatible" content = "IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/formularios.css">
    <title>Productos</title>
    <style>
        .back-button-container {
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
  <header>
    <h1>Dev Tech</h1>
  </header>
 <div class = "container">
  <div class = "form-container">
    <form action = "insert_productos.php" method = "POST">
      <h1>Productos</h1> 
      <label>ID producto</label><input type = "text" name = "id_producto" placeholder = "ID Producto" pattern="[A-Za-zÁ-Úá-úÑñ0-9 ]+" title="Solo números" required>
      <label>Nombre producto</label><input type = "text" name = "producto" placeholder = "Nombre Producto" pattern="[A-Za-zÁ-Úá-úÑñ0-9 ]+" required>
      <label>Modelo producto</label><input type = "text" name = "modelo" placeholder = "Modelo Producto" pattern="[A-Za-zÁ-Úá-úÑñ0-9 ]+" 
       title="Solo letras" required>
      <label>Descripcion corta</label><input type = "text" name = "descrip_corta" placeholder = "Descripción corta" pattern="[A-Za-zÁ-Úá-úÑñ0-9 .,\-&]+" 
       title="Solo letras, números, puntos, comas, guiones y &" required>
      <label>Descripcion larga</label><textarea name = "descrip_larga" placeholder = "Descripción larga" pattern="[A-Za-zÁ-Úá-úÑñ0-9 .,\-&]+" 
       title="Solo letras, números, puntos, comas, guiones y &" rows="3" required></textarea>
      <label>Precio compra</label><input type = "number" step ="0.01" name = "precio_compra" placeholder = "Precio compra" 
      onkeydown="return event.keyCode !== 69 && event.keyCode !== 187 && event.keyCode !== 189 && event.keyCode !== 190"
       value="<?= htmlspecialchars($row['precio_compra']) ?>"  required>
      <label>Precio venta</label><input type = "number" step ="0.01" name = "precio_venta" placeholder = "Precio venta" onkeydown="return event.keyCode !== 69 && event.keyCode !== 187 && event.keyCode !== 189 && event.keyCode !== 190"
       value="<?= htmlspecialchars($row['precio_venta']) ?>" required>
      <label>Stock</label><input type = "text" name = "stock" placeholder = "Stock" pattern="[0-9]+" title="Solo números" required>
      <label>Garantia en meses</label><input type = "text" name = "garantia" placeholder = "Garantia en meses" pattern="[0-9]+" title="Solo números" required>

      <input type = "submit" value = "Agregar producto">
    </form>
  </div>
  <div class="back-button-container">
    <a href="../gestionTienda.php" class="btn-back">← Volver al Menú de Gestión</a>
  </div>
</div>     
  <div>
    <h2>Productos registrados</h2>
      <table>
        <thead>
          <tr>
            <th>Id Producto</th>
            <th>Producto</th>
            <th>Modelo</th>
            <th>Descripción corta</th>
            <th>Descripción larga</th>
            <th>Precio compra</th>
            <th>Precio venta</th>
            <th>Stock</th>
            <th>Garantia en meses</th>
            <th>Acciones</th>
          <tr>
        </thead>
        <tbody>
          <?php while($row = mysqli_fetch_assoc($query2)):?>
          <tr>
          <td><?= $row['id_producto']?></td>
          <td><?= $row['producto']?></td>
          <td><?= $row['modelo']?></td>
          <td><?= $row['descrip_corta']?></td>
          <td><?= $row['descrip_larga']?></td>
          <td><?= $row['precio_compra']?></td>
          <td><?= $row['precio_venta']?></td>
          <td><?= $row['stock']?></td>
          <td><?= $row['garantia']?></td>
          
      <td class="action-links">
        <a href="update_productos.php?id=<?= $row['id_producto'] ?>" class="btn-edit">Editar</a>
        <a href="delete_productos.php?id=<?= $row['id_producto'] ?>" class="btn-delete"
          onclick="return confirm('¿Estás seguro de eliminar el producto <?= htmlspecialchars(addslashes($row['producto'])) ?>? Esta acción no se puede deshacer.')">
          Eliminar
        </a>
      </td>
          <tr>
          <?php endwhile;?>
        </tbody>
      </table>
  </div>
</body>
</html>