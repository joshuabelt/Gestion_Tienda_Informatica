<?php
function connection(){
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "tiendainformatica";

    $connect = mysqli_connect($host, $user, $pass, $bd);
    
    // Verificar conexión
    if (!$connect) {
        die("Error de conexión: " . mysqli_connect_error());
    }
    
    // Establecer el conjunto de caracteres
    mysqli_set_charset($connect, "utf8");
    
    return $connect;
}
?>