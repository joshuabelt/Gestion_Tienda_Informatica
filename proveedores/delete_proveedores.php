<?php
include('../connection.php');
$con = connection();

// Verificar si se recibió el ID y es válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de proveedor no proporcionado");
}

// Sanitizar el ID
$id = mysqli_real_escape_string($con, $_GET['id']);

// Verificar que el proveedor existe antes de eliminar
$check_sql = "SELECT id_proveedor FROM proveedores WHERE id_proveedor = '$id'";
$check_query = mysqli_query($con, $check_sql);

if (mysqli_num_rows($check_query) == 0) {
    die("El proveedor no existe o ya ha sido eliminado");
}

// Realizar la eliminación
$sql = "DELETE FROM proveedores WHERE id_proveedor = '$id'";
$query = mysqli_query($con, $sql);

if ($query) {
    // Redireccionar con mensaje de éxito
    header("Location: proveedores.php?delete_success=1");
    exit();
} else {
    // Mostrar error y opción para volver
    echo "Error al eliminar el proveedor: " . mysqli_error($con);
    echo "<br><a href='proveedores.php'>Volver al inicio</a>";
}
?>