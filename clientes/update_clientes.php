<?php
session_start();
include('../connection.php');
$con = connection();

$id = $_GET['id'] ?? '';
$stmt = mysqli_prepare($con, "SELECT * FROM clientes WHERE id=?");
mysqli_stmt_bind_param($stmt, "s", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);

if (!$row) {
    $_SESSION['error'] = "Cliente no encontrado";
    header("Location: clientes.php");
    exit();
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
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/css/intlTelInput.css">
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
    <form action="editclientes.php" method="POST" novalidate>
      <h1>Editar Clientes</h1>
      <input type="hidden" name="id_original" value="<?= $row['id'] ?>">
      <label>Id Cliente</label>
      <input type="text" value="<?= htmlspecialchars($row['id']) ?>" disabled>
      <label>Nombre</label><input type="text" name="nombre" placeholder="Nombre Cliente" value="<?= htmlspecialchars($row['nombre']) ?>" required>
      <label>Apellido</label><input type="text" name="apellido" placeholder="Apellido Cliente" value="<?= htmlspecialchars($row['apellido']) ?>" required>
      <label>Tipo cliente</label>
      <div style="margin-bottom:10px;">
        <input type="radio" name="tipo_cliente" value="persona natural" <?= ($row['tipo_cliente'] == 'persona natural') ? 'checked' : '' ?>> Natural
        <input type="radio" name="tipo_cliente" value="empresa" <?= ($row['tipo_cliente'] == 'empresa') ? 'checked' : '' ?>> Empresa
      </div>
     
      <label>Telefono</label>
       <input type="tel" name="telefono" id="telefono" placeholder="Teléfono" value="<?= htmlspecialchars($row['telefono']) ?>" required>
       <input type="hidden" name="pais_iso" id="pais_iso" value="">
      <label>Email</label><input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($row['email']) ?>" required>
      <label>País</label>
    <select name="pais" id="pais" required>
        <option value="">Seleccione un país</option>
    </select>

    <label>Departamento</label>
    <select name="departamento" id="departamento" required>
    <option value="">Seleccione un departamento...</option>
    </select>

    <label>Municipio</label>
    <select name="municipio" id="municipio" required>
    <option value="">Seleccione un municipio...</option>
    </select>

      <input type="submit" value="Actualizar información">
      <a class="btn-cancel" href="clientes.php" style="margin-left: 10px;">Cancelar</a>
    </form>
  </div>
  <script>
        const OLD = <?= json_encode($row) ?>;
    </script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/intlTelInput.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.js"></script>
  <script src="../js/telefono.js"></script>
  <script src="../js/location.js"></script>
  <script>
document.querySelector("form").addEventListener("submit", function(e) {
    if (!iti.isValidNumber()) {
        alert("Teléfono inválido");
        e.preventDefault();
        return;
    }

    telefono.value = iti.getNumber(intlTelInputUtils.numberFormat.E164);
    pais_iso.value = iti.getSelectedCountryData().iso2.toUpperCase();
});
</script>
</body>
</html>

