<?php
include('../connection.php');
$con = connection();

// Verificar si se recibió el ID y es válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de cliente no proporcionado");
}

// Sanitizar el ID
$id = mysqli_real_escape_string($con, $_GET['id']);

// Verificar que el cliente existe antes de eliminar
$check_sql = "SELECT id FROM clientes WHERE id = '$id'";
$check_query = mysqli_query($con, $check_sql);

if (mysqli_num_rows($check_query) == 0) {
    die("El cliente no existe o ya ha sido eliminado");
}

// Realizar la eliminación
$sql = "DELETE FROM clientes WHERE id = '$id'";
$query = mysqli_query($con, $sql);

if ($query) {
    // Redireccionar con mensaje de éxito
    header("Location: clientes.php?delete_success=3");
    exit();
} else {
    // Mostrar error y opción para volver
    echo "Error al eliminar el cliente: " . mysqli_error($con);
    echo "<br><a href='clientes.php'>Volver al inicio</a>";
}
?>

