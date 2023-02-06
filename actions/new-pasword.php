<?php
require_once '../data/bootstrap.php';
require_once '../data/conection.php';
require_once '../libraries/users.php';

$token      = $_POST['token'];
$email      = $_POST['email'];
$password   = $_POST['password'];

$user = userResetTokenIsValid($db, $token, $email);

if (!$user) {
    $_SESSION['status_error'] = "Ha ocurrido un error. Por favor, intenta de nuevo más tarde. Si el problema persiste, comunícate con el soporte.";
    header("Location: ../index.php?s=new-password&token=" . $token . "&email=" . $email);
    exit;
}

$success = userUpdatePassword($db, $user['id_user'], $password);

if ($success) {
    userDeleteToken($db, $token);

    $_SESSION['status_success'] = "¡Su contraseña se ha actualizado correctamente! Ya puedes iniciar sesión.";
    header("Location: ../index.php?s=login");
} else {
    $_SESSION['status_error'] = "Ha ocurrido un error al actualizar su contraseña. Por favor, intenta de nuevo más tarde. Si el problema persiste, comunícate con el soporte.";
    header("Location: ../index.php?s=new-password&token=" . $token . "&email=" . $email);
    exit;
}
