<?php
require_once '../data/bootstrap.php';
require_once '../libraries/users.php';
require_once '../libraries/auth.php';

$id_user    = $_GET['id_user'];
$name       = trim($_POST['name']);
$username   = trim($_POST['username']);
$location   = trim($_POST['location']);
$biography  = trim($_POST['biography']);
$email      = getUserById($db, $id_user)['email'];

$errors = [];

if (empty($name)) {
    $errors['name'] = "El nombre es obligatorio.";
}

if (empty($username)) {
    $errors['username'] = "El username es obligatorio.";
}

if (empty($location)) {
    $errors['location'] = "La ubicación es obligatoria.";
}

if (empty($biography)) {
    $errors['biography'] = "La biografía es obligatoria.";
}

if (!empty($errors)) {
    $_SESSION['old_data'] = $_POST;
    $_SESSION['errors'] = $errors;
    header("Location: ../index.php?s=sign-up");
    exit;
}

$id_user = userEdit($db, [
    'id_user'             => $id_user,
    'email'               => $email,
    'name'                => $name,
    'username'            => $username,
    'location'            => $location,
    'biography'           => $biography,
]);

if ($id_user !== false) {
    $_SESSION['status_success'] = "¡El usuario fue editado exitosamente!";
    header("Location: ../index.php?s=edit-profile");
    exit;
} else {
    $_SESSION['old_data'] = $_POST;
    $_SESSION['status_error'] = "Ha ocurrido un error al editar el usuario. Por favor, intenta de nuevo más tarde. Si el problema persiste, comunícate con el soporte.";
    header("Location: ../index.php?s=edit-profile");
    exit;
}
