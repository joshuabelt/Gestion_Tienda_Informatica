<?php 
 include('../connection.php');

 $con = connection();
 $sql1 = "SELECT * FROM proveedores";

 $query1 = mysqli_query($con, $sql1);

 if (!$query1) {
    die("Error en consulta de proveedores: " . mysqli_error($con));
}

if (isset($_GET['delete_success'])) {
    $message = "";
    if ($_GET['delete_success'] == 1) {
        $message = "Proveedor eliminado correctamente";
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
    <title>Proveedores</title>
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
    <form action = "insert_proveedores.php" method = "POST">
      <h1>Proveedores</h1>
      <label>ID proveedor</label><input type = "text" name = "id_proveedor" placeholder = "ID Proveedor" pattern="[A-Za-zÁ-Úá-úÑñ0-9 ]+" required>
      <label>Nombre proveedor</label><input type = "text" name = "proveedor" placeholder = "Nombre Proveedor" pattern="[A-Za-zÁ-Úá-úÑñ0-9 ]+" required>
      <label>Contacto</label><input type = "text" name = "contacto" placeholder = "Contacto" pattern="[A-Za-zÁ-Úá-úÑñ ]+" 
       title="Solo letras" required>
      <label>Cargo contacto</label><input type = "text" name = "cargo_contacto" placeholder = "Cargo contacto" pattern="[A-Za-zÁ-Úá-úÑñ ]+" 
       title="Solo letras" required>
      <label>Telefono contacto</label><input type = "tel" name = "telefono_contacto" placeholder = "Telefono contacto" pattern="[0-9+\- ]+" title="Solo números, espacios, + y guiones" required>
      <label>Email</label><input type = "email" name = "email" placeholder = "Email" required>
      <label>Pais</label><input type = "text" name = "pais" placeholder = "Pais" pattern="[A-Za-zÁ-Úá-úÑñ ]+" 
       title="Solo letras" required>
      <label>Departamento</label><input type = "text" name = "departamento" placeholder = "Departamento" pattern="[A-Za-zÁ-Úá-úÑ ]+" 
       title="Solo letras" required>
      <label>Municipio</label><input type = "text" name = "municipio" placeholder = "Municipio" pattern="[A-Za-zÁ-Úá-úÑñ ]+" 
       title="Solo letras" required>
      <input type = "submit" value = "Agregar proveedor" required>
    </form>
  </div>
  <div class="back-button-container">
    <a href="../gestionTienda.php" class="btn-back">← Volver al Menú de Gestión</a>
  </div>
</div>
  <div>
    <h2>Proveedores registrados</h2>
    <table>
     <thead>
        <tr>
           <th>ID Proveedor</th>
           <th>Proveedor</th>
           <th>Contacto</th>
           <th>Cargo contacto</th>
           <th>Telefono contacto</th>
           <th>Email</th>
           <th>País</th>
           <th>Departamento</th>
           <th>Municipio</th>
           <th>Acciones</th>
      </tr>
     </thead>
     <tbody>
       <?php while($row = mysqli_fetch_assoc($query1)):?>
         <tr>
          <td><?= htmlspecialchars($row['id_proveedor'])?></td>
          <td><?= htmlspecialchars($row['proveedor'])?></td>
          <td><?= htmlspecialchars($row['contacto'])?></td>
          <td><?= htmlspecialchars($row['cargo_contacto'])?></td>
          <td><?= htmlspecialchars($row['telefono_contacto'])?></td>
          <td><?= htmlspecialchars($row['email'])?></td>
          <td><?= htmlspecialchars($row['pais'])?></td>
          <td><?= htmlspecialchars($row['departamento'])?></td>
          <td><?= htmlspecialchars($row['municipio'])?></td>
          <td class="action-links">
          <a href="update_proveedores.php?id=<?= $row['id_proveedor'] ?>" class="btn-edit" >Editar</a>
          <a href="delete_proveedores.php?id=<?= $row['id_proveedor'] ?>" class="btn-delete"
          onclick="return confirm('¿Estás seguro de eliminar el proveedor <?= htmlspecialchars(addslashes($row['proveedor'])) ?>? Esta acción no se puede deshacer.')">Eliminar</a>
         </td>
         <tr>
        <?php endwhile;?>
     </tbody>
    <table>
  </div>
   <script src="proveedores.js"></script>
 </body>
</html>