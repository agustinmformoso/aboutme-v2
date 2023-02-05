<?php
require_once '../data/bootstrap.php';
require_once '../data/conection.php';
require_once '../libraries/users.php';

$token      = $_POST['token'];
$email      = $_POST['email'];
$password   = $_POST['password'];

$user = userResetTokenIsValid($db, $token, $email);
if (!$user) {
    $_SESSION['status_error'] = "El pedido es inválido. Por favor, probá de nuevo. Si el problema persiste, repetí el proceso una vez más.";
    header("Location: ../index.php?s=new-password&token=" . $token . "&email=" . $email);
    exit;
}

$success = userUpdatePassword($db, $user['id_user'], $password);

if ($success) {
    userDeleteToken($db, $token);

    $_SESSION['status_success'] = "¡La contraseña se actualizó correctamente! Ya podes iniciar sesión.";
    header("Location: ../index.php?s=login");
} else {
    $_SESSION['status_error'] = "Hubo un error al actualizar la contraseña. Por favor, intentá de nuevo. Si el problema persiste, comunicate con el soporte.";
    header("Location: ../index.php?s=new-password&token=" . $token . "&email=" . $email);
    exit;
}
