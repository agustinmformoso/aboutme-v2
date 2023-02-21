<?php
require_once '../data/bootstrap.php';
require_once '../libraries/users.php';
require_once '../libraries/auth.php';

$name       = trim($_POST['name']);
$username   = trim($_POST['username']);
$email      = trim($_POST['email']);
$password   = trim($_POST['password']);
$birthdate  = trim($_POST['birthdate']);
$location   = trim($_POST['location']);
$biography  = trim($_POST['biography']);
$profile_picture  = 'default-profile.png';
$profile_picture_alt  = 'Default profile picture';

$errors = [];

if (empty($email)) {
    $errors['email'] = "El mail es obligatorio.";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors['email'] = "El formato del email es inválido, revisá que sea: 'nombre@dominio.extension'.";
}

if (empty($password)) {
    $errors['password'] = "La contraseña es obligatoria.";
}

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

if (empty($birthdate)) {
    $errors['birthdate'] = "La fecha de nacimiento es obligatoria.";
}

if (!empty($errors)) {
    $_SESSION['old_data'] = $_POST;
    $_SESSION['errors'] = $errors;
    header("Location: ../index.php?s=sign-up");
    exit;
}

$id_user = userCreate($db, [
    'email'               => $email,
    'password'            => $password,
    'name'                => $name,
    'username'            => $username,
    'location'            => $location,
    'biography'           => $biography,
    'birthdate'           => $birthdate,
    'profile_picture'     => $profile_picture,
    'profile_picture_alt' => $profile_picture_alt,
]);

if ($id_user !== false) {
    authSetLogin([
        'id_user'             => $id_user,
        'email'               => $email,
        'name'                => $name,
        'username'            => $username,
        'location'            => $location,
        'biography'           => $biography,
        'birthdate'           => $birthdate,
        'profile_picture'     => $profile_picture,
        'profile_picture_alt' => $profile_picture_alt,
    ]);

    $_SESSION['status_success'] = "¡El usuario fue creado exitosamente!";
    header("Location: ../index.php?s=profile&id=$id_user");
    exit;
} else {
    $_SESSION['old_data'] = $_POST;
    $_SESSION['status_error'] = "Ha ocurrido un error al crear el usuario. Por favor, intenta de nuevo más tarde. Si el problema persiste, comunícate con el soporte.";
    header("Location: ../index.php?s=sign-up");
    exit;
}
