<?php 
session_start();
include('../connection.php');

$con = connection();
$sql = "SELECT * FROM clientes";
$query = mysqli_query($con, $sql);

$old = $_SESSION['old'] ?? [];

if (!$query) {
    die("Error en consulta de clientes: " . mysqli_error($con));
}

if (isset($_GET['delete_success'])) {
    $message = "";
    if ($_GET['delete_success'] == 3) {
        $message = "Cliente eliminado correctamente";
    }
    echo "<div style='background-color: #d4edda; color: #155724; padding: 10px; margin: 10px 0; border: 1px solid #c3e6cb; border-radius: 4px;'>
            {$message}
            <span style='float: right; cursor: pointer;' onclick='this.parentElement.style.display=\"none\"'>×</span>
          </div>";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/formularios.css">
    <title>Clientes</title>
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

<div class="container">
<div class="form-container">

<!-- 🔴 MENSAJE DE ERROR -->
<?php if (isset($_SESSION['error'])): ?>
    <div style="background:#f8d7da;color:#721c24;padding:10px;margin-bottom:10px;border-radius:4px;">
        <?= $_SESSION['error'] ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<!-- 🟢 MENSAJE DE ÉXITO -->
<?php if (isset($_SESSION['success'])): ?>
    <div style="background:#d4edda;color:#155724;padding:10px;margin-bottom:10px;border-radius:4px;">
        <?= $_SESSION['success'] ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>
<!-- FORMULARIO -->
<form action="insert_clientes.php" method="POST" novalidate>
    <h1>Registrar Cliente</h1>

    <label>ID Cliente</label>
    <input type="text" name="id" placeholder="ID Cliente" value="<?= htmlspecialchars($old['id']?? '')?>" required>

    <label>Nombre</label>
    <input type="text" name="nombre" placeholder="Nombre Cliente" value="<?= htmlspecialchars($old['nombre']?? '')?>" required>

    <label>Apellido</label>
    <input type="text" name="apellido" placeholder="Apellido Cliente" value="<?= htmlspecialchars($old['apellido']?? '')?>" required>

    <label>Tipo cliente</label>
    <div style="margin-bottom:10px;">
        <input type="radio" name="tipo_cliente" value="persona natural" <?= (($old['tipo_cliente'] ?? '') === 'persona natural') ? 'checked' : '' ?> required> Persona natural 
        <input type="radio" name="tipo_cliente" value="empresa" <?= (($old['tipo_cliente'] ?? '') === 'empresa') ? 'checked' : '' ?>> Empresa
    </div>

    <label>Teléfono</label>
    <input type="tel" name="telefono" id="telefono" placeholder="Incluya código del país" value="<?= htmlspecialchars($old['telefono'] ?? '') ?>" required>
    <input type="hidden" name="pais_iso" id="pais_iso" value="<?= htmlspecialchars($old['pais_iso'] ?? '') ?>">

    <label>Email</label>
    <input type="email" name="email" placeholder="Email" value="<?= htmlspecialchars($old['email'] ?? '') ?>" required>

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

    <input type="submit" value="Agregar cliente">
</form>

</div>
</div>

<div class="back-button-container">
    <a href="../gestionTienda.php" class="btn-back">← Volver al Menú de Gestión</a>
</div>

<!-- TABLA CLIENTES -->
<div>
    <h2>Clientes registrados</h2>
    <table>
        <thead>
            <tr>
                <th>Id Cliente</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>Tipo Cliente</th>
                <th>Telefono</th>
                <th>Email</th>
                <th>Pais</th>
                <th>Departamento</th>
                <th>Municipio</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
        <?php while ($row = mysqli_fetch_assoc($query)): ?>
            <tr>
                <td><?= htmlspecialchars($row['id']) ?></td>
                <td><?= htmlspecialchars($row['nombre']) ?></td>
                <td><?= htmlspecialchars($row['apellido']) ?></td>
                <td><?= htmlspecialchars($row['tipo_cliente']) ?></td>
                <td><?= htmlspecialchars($row['telefono']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['pais']) ?></td>
                <td><?= htmlspecialchars($row['departamento']) ?></td>
                <td><?= htmlspecialchars($row['municipio']) ?></td>

                <td class="action-links">
                    <a href="update_clientes.php?id=<?= $row['id'] ?>" class="btn-edit">Editar</a>
                    <a href="delete_clientes.php?id=<?= $row['id'] ?>" class="btn-delete"
                       onclick="return confirm('¿Estás seguro de eliminar el registro del cliente <?= htmlspecialchars(addslashes($row['nombre'])) ?>? Esta acción no se puede deshacer.')">
                       Eliminar
                    </a>
                </td>
            </tr>
        <?php endwhile; ?>
        </tbody>
    </table>
</div>
<script>
const OLD = <?= json_encode($old ?? []) ?>;
</script>
<script src="../js/location.js"></script>
<?php unset($_SESSION['old']); ?>
</body>
</html>
