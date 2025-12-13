<?php
include('../connection.php');
$con = connection();

// Verificar si se recibió el ID y es válido
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID de producto no proporcionado");
}

// Sanitizar el ID
$id = mysqli_real_escape_string($con, $_GET['id']);

// Verificar que el producto existe antes de eliminar
$check_sql = "SELECT id_producto FROM productos WHERE id_producto = '$id'";
$check_query = mysqli_query($con, $check_sql);

if (mysqli_num_rows($check_query) == 0) {
    die("El producto no existe o ya ha sido eliminado");
}

// Realizar la eliminación
$sql = "DELETE FROM productos WHERE id_producto = '$id'";
$query = mysqli_query($con, $sql);

if ($query) {
    // Redireccionar con mensaje de éxito
    header("Location: productos.php?delete_success=2");
    exit();
} else {
    // Mostrar error y opción para volver
    echo "Error al eliminar el producto: " . mysqli_error($con);
    echo "<br><a href='productos.php'>Volver al inicio</a>";
}
?>