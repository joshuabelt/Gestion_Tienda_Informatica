<?php
include('../connection.php');
$con = connection();

// Verificar si se recibió el ID
if (!isset($_GET['id'])) {
    header("Location: proveedores.php");
    exit();
}

$id = mysqli_real_escape_string($con, $_GET['id']);
$sql = "SELECT * FROM proveedores WHERE id_proveedor='$id'";
$query = mysqli_query($con, $sql);

// Verificar si la consulta fue exitosa
if (!$query) {
    die("Error en la consulta: " . mysqli_error($con));
}

$row = mysqli_fetch_assoc($query);

// Verificar si se encontró el proveedor
if (!$row) {
    die("Proveedor no encontrado");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar proveedores</title>
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
    <form action="editproveedores.php" method="POST">
      <h1>Editar Proveedor</h1>
      <label>Id Proveedor</label><input type="text" name="id_proveedor" pattern="[A-Za-zÁ-Úá-úÑñ0-9 ]+" value="<?= htmlspecialchars($row['id_proveedor']) ?>" required>   
      <label>Nombre Proveedor</label><input type="text" name="proveedor" placeholder="Nombre Proveedor" pattern="[A-Za-zÁ-Úá-úÑñ0-9 ]+" value="<?= htmlspecialchars($row['proveedor']) ?>" required>
      <label>Contacto</label><input type="text" name="contacto" placeholder="Contacto" pattern="[A-Za-zÁ-Úá-úÑñ ]+" 
       title="Solo letras" value="<?= htmlspecialchars($row['contacto']) ?>" required>
      <label>Cargo contacto</label><input type="text" name="cargo_contacto" placeholder="Cargo contacto" pattern="[A-Za-zÁ-Úá-úÑñ ]+" 
       title="Solo letras" value="<?= htmlspecialchars($row['cargo_contacto']) ?>" required>
      <label>Telefono contacto</label><input type="tel" name="telefono_contacto" placeholder="Teléfono contacto" pattern="[0-9+\- ]+" 
      title="Solo números, espacios, + y guiones" value="<?= htmlspecialchars($row['telefono_contacto']) ?>" required>
      <label>Email</label><input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($row['email']) ?>" required>
      <label>Pais</label><input type="text" name="pais" placeholder="País" pattern="[A-Za-zÁ-Úá-úÑñ ]+" 
       title="Solo letras" value="<?= htmlspecialchars($row['pais']) ?>" required>
      <label>Departamento</label><input type="text" name="departamento" placeholder="Departamento" pattern="[A-Za-zÁ-Úá-úÑñ ]+" 
       title="Solo letras" value="<?= htmlspecialchars($row['departamento']) ?>" required>
      <label>Municipio</label><input type="text" name="municipio" placeholder="Municipio" pattern="[A-Za-zÁ-Úá-úÑñ ]+" 
       title="Solo letras" value="<?= htmlspecialchars($row['municipio']) ?>" required>

      <input type="submit" value="Actualizar información">
      <a class="btn-cancel" href="proveedores.php" style="margin-left: 10px;">Cancelar</a>
    </form>
  </div>
  <script src="proveedores.js"></script>
</body>
</html>