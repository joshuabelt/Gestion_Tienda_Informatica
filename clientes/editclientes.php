<?php
session_start();

require '../vendor/autoload.php';
include('../connection.php');

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
$con = connection();

$id = trim($_POST['id_original']);
$nombre = trim($_POST['nombre']);
$apellido = trim($_POST['apellido']);
$tipo_cliente = $_POST['tipo_cliente'];
$telefono = trim($_POST['telefono']);
$pais_iso = $_POST['pais_iso'] ?? null;
$email = trim($_POST['email']);
$pais = trim($_POST['pais']);
$departamento = trim($_POST['departamento']);
$municipio = trim($_POST['municipio']);

if ($nombre === '' || !preg_match('/^[A-Za-zÁ-Úá-úÑñ ]+$/', $nombre)) {
    $_SESSION['error'] = "❌ El nombre es inválido.";
    header("Location: clientes.php");
    exit();
}

if ($apellido === '' || !preg_match('/^[A-Za-zÁ-Úá-úÑñ ]+$/', $apellido)) {
    $_SESSION['error'] = "❌ El apellido es inválido.";
    header("Location: clientes.php");
    exit();
}

if (!in_array($tipo_cliente, ['persona natural', 'empresa'])) {
    $_SESSION['error'] = "❌ Tipo de cliente inválido.";
    header("Location: clientes.php");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "❌ El email no es válido.";
    header("Location: clientes.php");
    exit();
}

if ($pais === '' || $departamento === '' || $municipio === '') {
    $_SESSION['error'] = "❌ Datos de ubicación incompletos.";
    header("Location: clientes.php");
    exit();
}

$phoneUtil = PhoneNumberUtil::getInstance();

try {
  $numberProto = $phoneUtil->parse($telefono, $pais_iso);
    if (!$phoneUtil->isValidNumber($numberProto)) {
        throw new Exception();
    }
    $telefono = $phoneUtil->format($numberProto, PhoneNumberFormat::E164);

} catch (Exception $e) {
    $_SESSION['error'] = "❌ Teléfono inválido.";
    header("Location: clientes.php");
    exit();
}

$sql = "SELECT id FROM clientes WHERE email = ? AND id != ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "ss", $email, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    $_SESSION['error'] = "❌ El correo electrónico ya pertenece a otro cliente.";
    header("Location: clientes.php");
    exit();
}

$sql = "SELECT id FROM clientes WHERE telefono = ? AND id != ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "ss", $telefono, $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    $_SESSION['error'] = "❌ El número de teléfono ya pertenece a otro cliente.";
    header("Location: clientes.php");
    exit();
}

$stmt = mysqli_prepare($con,
"UPDATE clientes SET
nombre=?, apellido=?, tipo_cliente=?, telefono=?, email=?, pais=?, departamento=?, municipio=?
WHERE id=?");

mysqli_stmt_bind_param($stmt,"sssssssss",
$nombre,$apellido,$tipo_cliente,$telefono,$email,$pais,$departamento,$municipio,$id);

mysqli_stmt_execute($stmt);

$_SESSION['success'] = "✅ Cliente actualizado correctamente.";
header("Location: clientes.php");
exit();



