<?php
include('../connection.php');
$con = connection();

// Verificar si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir y sanitizar datos
    $id_proveedor = mysqli_real_escape_string($con, $_POST['id_proveedor']);
    $proveedor = mysqli_real_escape_string($con, $_POST['proveedor']);
    $nombre_contacto = mysqli_real_escape_string($con, $_POST['contacto']);
    $cargo_contacto = mysqli_real_escape_string($con, $_POST['cargo_contacto']);
    $telefono_contacto = mysqli_real_escape_string($con, $_POST['telefono_contacto']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $pais = mysqli_real_escape_string($con, $_POST['pais']);
    $departamento = mysqli_real_escape_string($con, $_POST['departamento']);
    $municipio = mysqli_real_escape_string($con, $_POST['municipio']);

    //Consultar para insertar datos
    $sql = "INSERT INTO proveedores (id_proveedor, proveedor, contacto, cargo_contacto, telefono_contacto, email, pais, departamento, municipio) 
            VALUES ('$id_proveedor', '$proveedor', '$nombre_contacto', '$cargo_contacto', '$telefono_contacto', '$email', '$pais', '$departamento', '$municipio')";

    $query = mysqli_query($con, $sql);

    if($query){
        header("Location: proveedores.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($con);
    }
} else {
    header("Location: proveedores.php");
    exit();
}
?>