<?php
header("Content-Type: application/json");

if (!isset($_GET['country_id'])) {
    echo json_encode([]);
    exit;
}

$country_id = intval($_GET['country_id']);

$states = json_decode(file_get_contents("../data/states.json"), true);

// Filtrar estados por país
$result = array_values(array_filter($states, function($state) use ($country_id) {
    return intval($state['country_id']) === $country_id;
}));

echo json_encode($result);
?>
