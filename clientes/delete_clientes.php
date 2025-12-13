<?php
include('../connection.php');
$con = connection();

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM clientes WHERE id=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("s", $id);

    $stmt->execute();
}

header("Location: clientes.php");
exit();
?>
