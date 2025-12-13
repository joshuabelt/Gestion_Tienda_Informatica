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

    //Consulta para insertar datos
    $sql = "INSERT INTO productos (id_producto, producto, modelo, descrip_corta, descrip_larga, precio_compra, precio_venta, stock, garantia) 
            VALUES ('$id_producto', '$producto', '$modelo', '$desc_corta', '$desc_larga', '$precio_compra', '$precio_venta', '$stock', '$garantia')";

    $query = mysqli_query($con, $sql);

    if($query){
        header("Location: productos.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    header("Location: productos.php");
    exit();
}
?>