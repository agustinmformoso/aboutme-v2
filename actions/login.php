<?php
require_once '../data/bootstrap.php';
require_once '../libraries/auth.php';

$email    = trim($_POST['email']);
$password = trim($_POST['password']);

$errors = [];

if (empty($email)) {
    $errors['email'] = "El campo email esta vacío.";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "El formato del email es inválido, revisá que sea: 'nombre@dominio.extension'.";
}

if (!empty($errors)) {
    $_SESSION['old_data'] = $_POST;
    $_SESSION['errors'] = $errors;
    header('Location: ../index.php?s=login');
    exit;
}

if (authLogin($db, $email, $password)) {
    $seccion = $_SESSION['intended_section'] ?? 'home';
    unset($_SESSION['intended_section']);
    header('Location: ../index.php?s=' . $seccion);
    exit;
} else {
    $_SESSION['old_data'] = $_POST;
    $_SESSION['status_error'] = "Las credenciales ingresadas no coinciden con nuestros registros.";
    header('Location: ../index.php?s=login');
    exit;
}
