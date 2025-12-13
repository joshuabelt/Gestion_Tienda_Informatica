<?php
header("Content-Type: application/json");

if (!isset($_GET['state_id'])) {
    echo json_encode([]);
    exit;
}

$state_id = intval($_GET['state_id']);

$cities = json_decode(file_get_contents("../data/cities.json"), true);

// Filtrar ciudades por estado
$result = array_values(array_filter($cities, function($city) use ($state_id) {
    return intval($city['state_id']) === $state_id;
}));

echo json_encode($result);
?>
