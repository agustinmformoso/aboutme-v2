<?php
require_once '../data/bootstrap.php';
require_once '../data/conection.php';
require_once '../libraries/users.php';

$email = $_POST['email'];

$errors = [];

$user = getUserByEmail($db, $email);

if (empty($email)) {
    $errors['email'] = "El mail esta vacío.";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "El formato del email es inválido, revisá que sea: 'nombre@dominio.extension'.";
}

if (!empty($errors)) {
    $_SESSION['old_data'] = $_POST;
    $_SESSION['errors'] = $errors;
    header('Location: ../index.php?s=password-reset');
    exit;
}

if (!$user) {
    $_SESSION['old_data'] = $_POST;
    $_SESSION['status_error'] = "El email no es válido. Por favor intenta nuevamente.";
    header('Location: ../index.php?s=password-reset');
    exit;
}

$token = userGetTokenById($db, $user['id_user']);

if ($token) {
    userDeleteToken($db, $token);
}

$token = userGenerateResetToken($db, $user['id_user']);

$body = file_get_contents(__DIR__ . '/../emails/new-password.html');

$link = "http://localhost/www/aboutme-v2/index.php?s=new-password&token=" . $token . "&email=" . $email;

$body = str_replace('@@EMAIL@@', $email, $body);
$body = str_replace('@@URL@@', $link, $body);

$subject = "About Me | Cambio de contraseña";

$headers  = "From: noreply@aboutme.com" . "\r\n";
$headers .= "MIME-Version: 1.0" . "\r\n";
$headers .= "Content-Type: text/html; charset=utf-8" . "\r\n";

if (!mail($email, $subject, $body, $headers)) {
    $fileName = date('Ymd_His') . "_new-password.html";
    file_put_contents(__DIR__ . "/../emails/sent/" . $fileName, $body);
}

$_SESSION['status_success'] = "Te enviamos un email con instrucciones para cambiar tu contraseña. Si no ves el mail, verifica tu casilla de spam o correo basura.";
header('Location: ../index.php?s=password-reset');
