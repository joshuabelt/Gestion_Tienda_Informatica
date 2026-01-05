<?php
session_start();
require '../vendor/autoload.php';
include('../connection.php');

use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;

$con = connection();

$id = trim($_POST['id']);
$nombre = trim($_POST['nombre']);
$apellido = trim($_POST['apellido']);
$tipo_cliente = $_POST['tipo_cliente'] ?? '';
$telefono = trim($_POST['telefono']);
$pais_iso = $_POST['pais_iso'] ?? '';
$email = trim($_POST['email']);
$pais = trim($_POST['pais']);
$departamento = trim($_POST['departamento']);
$municipio = trim($_POST['municipio']);

$_SESSION['old'] = [
    'id' => $id,
    'nombre' => $nombre,
    'apellido' => $apellido,
    'tipo_cliente' => $tipo_cliente,
    'telefono' => $telefono,
    'email' => $email,
    'pais' => $pais,
    'pais_iso' => $pais_iso,
    'departamento' => $departamento,
    'municipio' => $municipio
];
// ID
if ($id === '' || !preg_match('/^[A-Za-zÁ-Úá-úÑñ0-9 ]+$/', $id)) {
    $_SESSION['error'] = "❌ El ID del cliente es inválido.";
    header("Location: clientes.php");
    exit();
}

// Nombre
if ($nombre === '' || !preg_match('/^[A-Za-zÁ-Úá-úÑñ ]+$/', $nombre)) {
    $_SESSION['error'] = "❌ El nombre solo debe contener letras.";
    header("Location: clientes.php");
    exit();
}

// Apellido
if ($apellido === '' || !preg_match('/^[A-Za-zÁ-Úá-úÑñ ]+$/', $apellido)) {
    $_SESSION['error'] = "❌ El apellido solo debe contener letras.";
    header("Location: clientes.php");
    exit();
}

// Tipo cliente
if (!in_array($tipo_cliente, ['persona natural', 'empresa'])) {
    $_SESSION['error'] = "❌ Tipo de cliente no válido.";
    header("Location: clientes.php");
    exit();
}

// Email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['error'] = "❌ El correo electrónico no es válido.";
    header("Location: clientes.php");
    exit();
}

// País / ubicación
if ($pais === '' || $departamento === '' || $municipio === '') {
    $_SESSION['error'] = "❌ Debe seleccionar país, departamento y municipio.";
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
    $_SESSION['error'] = "❌ Número de teléfono inválido.";
    header("Location: clientes.php");
    exit();
}
$sql = "SELECT id FROM clientes WHERE email = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    $_SESSION['error'] = "❌ El correo electrónico ya está registrado.";
    header("Location: clientes.php");
    exit();
}

$stmt = mysqli_prepare($con, "SELECT id FROM clientes WHERE email=? OR telefono=?");
mysqli_stmt_bind_param($stmt, "s", $telefono, $email);
mysqli_stmt_execute($stmt);
mysqli_stmt_store_result($stmt);

if (mysqli_stmt_num_rows($stmt) > 0) {
    $_SESSION['error'] = "❌ El correo electrónico o telefóno ya está registrado.";
    header("Location: clientes.php");
    exit();
}

/* INSERT */

$stmt = mysqli_prepare(
    $con,
    "INSERT INTO clientes VALUES (?,?,?,?,?,?,?,?,?)"
);

mysqli_stmt_bind_param(
    $stmt,
    "sssssssss",
    $id, $nombre, $apellido, $tipo_cliente,
    $telefono, $email, $pais, $departamento, $municipio
);

mysqli_stmt_execute($stmt);

$_SESSION['success'] = "✅ Cliente registrado correctamente.";
header("Location: clientes.php");
exit();



