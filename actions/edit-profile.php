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
$profile_picture       = basename($_FILES["profile_picture"]["name"]);
$profile_picture_alt   = $name . " profile picture";
$banner_picture        = basename($_FILES["banner_picture"]["name"]);
$banner_picture_alt    = $name . " banner picture";

$dir = PATH_IMG;
$file_path_pp = $dir . $profile_picture;
$file_path_banner = $dir . $banner_picture;

if (!empty($_FILES["profile_picture"]["name"])) {
    move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $file_path_pp);
}

if (!empty($_FILES["banner_picture"]["name"])) {
    move_uploaded_file($_FILES["banner_picture"]["tmp_name"], $file_path_banner);
}

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
    'profile_picture'     => $profile_picture,
    'profile_picture_alt' => $profile_picture_alt,
    'banner_picture'      => $banner_picture,
    'banner_picture_alt'  => $banner_picture_alt,
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
