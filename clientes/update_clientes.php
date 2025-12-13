<?php
include('../connection.php');
$con = connection();

// --- VALIDAR SI SE RECIBIÓ ID ---
if (!isset($_GET['id'])) {
    header("Location: clientes.php");
    exit();
}

$id = $_GET['id'];

$sql = "SELECT * FROM clientes WHERE id=?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if (!$row) die("Cliente no encontrado.");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar clientes</title>
    <link rel="stylesheet" href="../styles/update.css">

<style>
body { font-family: Arial, sans-serif; margin: 20px; }
.form-container { max-width: 600px; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
h1 { margin-top: 0; }
input[type="text"], input[type="tel"], input[type="email"] {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
}
input[type="submit"] {
    background-color: #2196F3;
    color: white;
    padding: 10px 15px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
input[type="submit"]:hover { background-color: #0b7dda; }
.btn-cancel {
    background-color: #f44336;
    color: white;
    padding: 10px 15px;
    border-radius: 4px;
    text-decoration: none;
    display: inline-block;
}
.btn-cancel:hover { background-color: #c62828; }

.radio-group label {
    display: block;
    margin-bottom: 5px;
}
</style>
</head>

<body>
<div class="form-container">
    <form action="editclientes.php" method="POST">
        <h1>Editar clientes</h1>
        <input type="hidden" name="id_original" value="<?= htmlspecialchars($row['id']) ?>">
        <label>Id Cliente</label>
        <input type="text" name="id" pattern="[A-Za-zÁ-Úá-úÑñ0-9 ]+"
               value="<?= htmlspecialchars($row['id']) ?>" required>

        <label>Nombre</label>
        <input type="text" name="nombre" placeholder="Nombre Cliente"
               pattern="[A-Za-zÁ-Úá-úÑñ ]+" title="Solo letras"
               value="<?= htmlspecialchars($row['nombre']) ?>" required>

        <label>Apellido</label>
        <input type="text" name="apellido" placeholder="Apellido Cliente"
               pattern="[A-Za-zÁ-Úá-úÑñ ]+" title="Solo letras"
               value="<?= htmlspecialchars($row['apellido']) ?>" required>

        <label>Tipo cliente</label>
        <div class="radio-group">
            <label>
                <input type="radio" name="tipo_cliente" value="persona natural"
                       <?= ($row['tipo_cliente'] === 'persona natural') ? 'checked' : '' ?> required>
                Persona Natural
            </label>

            <label>
                <input type="radio" name="tipo_cliente" value="empresa"
                       <?= ($row['tipo_cliente'] === 'empresa') ? 'checked' : '' ?>>
                Empresa
            </label>
        </div>

        <label>Teléfono</label>
        <input type="tel" name="telefono" placeholder="Teléfono"
               pattern="[0-9+\- ]+" value="<?= htmlspecialchars($row['telefono']) ?>" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="Email"
               value="<?= htmlspecialchars($row['email']) ?>" required>

        <label>País</label>
        <select name="pais" id="pais" required data-selected="<?= $row['pais'] ?>"></select>

        <label>Departamento</label>
        <select name="departamento" id="departamento" required data-selected="<?= $row['departamento'] ?>"></select>

        <label>Municipio</label>
        <select name="municipio" id="municipio" required data-selected="<?= $row['municipio'] ?>"></select>

        <input type="submit" value="Actualizar información">
        <a class="btn-cancel" href="clientes.php" style="margin-left:10px;">Cancelar</a>
    </form>
</div>

<script src="clientes.js"></script>
<script src="../js/location.js"></script>
</body>
</html>
