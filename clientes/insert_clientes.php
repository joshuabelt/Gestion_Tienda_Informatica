<?php
include('../connection.php');
$con = connection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    // ----------- SANITIZAR CAMPOS -----------
    $id_cliente   = trim($_POST['id']);
    $nombre       = trim($_POST['nombre']);
    $apellido     = trim($_POST['apellido']);
    $tipo_cliente = trim($_POST['tipo_cliente']);
    $telefono     = trim($_POST['telefono']);
    $email        = trim($_POST['email']);
    $pais         = trim($_POST['pais']);
    $departamento = trim($_POST['departamento']);
    $municipio    = trim($_POST['municipio']);

    $countries = json_decode(file_get_contents("../data/countries(1).json"), true);
    $states = json_decode(file_get_contents("../data/states.json"), true);
    $cities = json_decode(file_get_contents("../data/citiesjson/cities.json"), true);

    $valid_country = array_search($pais, array_column($countries, "id")) !== false;
    $valid_state = array_search($departamento, array_column($states, "id")) !== false;
    $valid_city = array_search($municipio, array_column($cities, "id")) !== false;
   
    if (!$valid_country || !$valid_state || !$valid_city) {
        die("Error: País, departamento o municipio inválido.");
    }

    // =========================
    // INSERCIÓN
    // =========================
    $sql = "INSERT INTO clientes (id, nombre, apellido, tipo_cliente, telefono, email, pais, departamento, municipio)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("sssssssss", $id, $nombre, $apellido, $tipo_cliente, $telefono, $email, $pais, $departamento, $municipio);

    if ($stmt->execute()) {
        header("Location: clientes.php");
        exit();
    } else {
        echo "Error al insertar: " . $stmt->error;
    }
}

?>
