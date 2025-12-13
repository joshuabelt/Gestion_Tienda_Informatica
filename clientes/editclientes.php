<?php
include('../connection.php');
$con = connection();

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $tipo_cliente = $_POST['tipo_cliente'];
    $telefono = $_POST['telefono'];
    $email = $_POST['email'];
    $pais = $_POST['pais'];
    $departamento = $_POST['departamento'];
    $municipio = $_POST['municipio'];

    // VALIDACIÓN JSON
    $countries = json_decode(file_get_contents("../data/countries(1).json"), true);
    $states = json_decode(file_get_contents("../data/states.json"), true);
    $cities = json_decode(file_get_contents("../data/citiesjson/cities.json"), true);

    $valid_country = array_search($pais, array_column($countries, "id")) !== false;
    $valid_state = array_search($departamento, array_column($states, "id")) !== false;
    $valid_city = array_search($municipio, array_column($cities, "id")) !== false;

    if (!$valid_country || !$valid_state || !$valid_city) {
        die("Error: País, departamento o municipio inválido.");
    }

    // UPDATE
    $sql = "UPDATE clientes SET id=?, nombre=?, apellido=?, tipo_cliente=?, telefono=?, email=?, pais=?, departamento=?, municipio=? WHERE id=?";

    $stmt = $con->prepare($sql);
    $stmt->bind_param("ssssssssss", $id, $nombre, $apellido, $tipo_cliente, $telefono, $email, $pais, $departamento, $municipio);

    if ($stmt->execute()) {
        header("Location: clientes.php");
        exit();
    } else {
        echo "Error al actualizar: " . $stmt->error;
    }
}
?>
