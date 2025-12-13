<?php
include('../connection.php');
$con = connection();

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y sanitizar datos
    $id_producto = mysqli_real_escape_string($con, $_POST['id_producto']);
    $producto = mysqli_real_escape_string($con, $_POST['producto']);
    $modelo = mysqli_real_escape_string($con, $_POST['modelo']);
    $desc_corta = mysqli_real_escape_string($con, $_POST['descrip_corta']);
    $desc_larga = mysqli_real_escape_string($con, $_POST['descrip_larga']);
    $precio_compra = mysqli_real_escape_string($con, $_POST['precio_compra']);
    $precio_venta = mysqli_real_escape_string($con, $_POST['precio_venta']);
    $stock = mysqli_real_escape_string($con, $_POST['stock']);
    $garantia = mysqli_real_escape_string($con, $_POST['garantia']);

    // Crear consulta UPDATE 
    $sql = "UPDATE productos SET 
            producto = '$producto', 
            modelo = '$modelo', 
            descrip_corta = '$desc_corta', 
            descrip_larga = '$desc_larga', 
            precio_compra = '$precio_compra', 
            precio_venta = '$precio_venta', 
            stock = '$stock', 
            garantia = '$garantia' 
            WHERE id_producto = '$id_producto'";

    $query = mysqli_query($con, $sql);

    if($query){
        header("Location: productos.php");
        exit();
    } else {
        echo "Error al actualizar: " . mysqli_error($con);
        echo "<br><a href='productos.php'>Volver al inicio</a>";
    }
} else {
    header("Location: productos.php");
    exit();
}
?>