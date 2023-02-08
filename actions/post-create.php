<?php
require_once '../data/bootstrap.php';
require_once '../libraries/posts.php';
require_once '../libraries/auth.php';

$id_user    = $_GET['id'];
$section    = $_GET['s'];
$id_user    = $_GET['id_user'];
$type       = trim($_POST['type']);
$title      = trim($_POST['title']);
$content    = trim($_POST['content']);
$rating     = trim($_POST['rating']);

$errors = [];

function redirect()
{
    // @TODO - - > Redirect
}


if (empty($title)) {
    $errors['title'] = "El título no puede estar vacío.";
}

if (empty($type)) {
    $errors['type'] = "El tipo no puede estar vacío.";
}

if (empty($content)) {
    $errors['content'] = "El contenido no puede estar vacío.";
}

if (!empty($errors)) {
    $_SESSION['old_data'] = $_POST;
    $_SESSION['errors'] = $errors;

    if ($section == 'home') {
        header("Location: ../index.php?s=home");
    } else {
        header("Location: ../index.php?s=profile&id=$id_user");
    }

    exit;
}

$success = createPost($db, [
    'id_user' => $id_user,
    'title'   => $title,
    'type'    => $type,
    'content' => $content,
    'rating'  => $rating ? $rating : 0,
]);

if ($success) {
    $_SESSION['status_success'] = "¡Post enviado con éxito!";
    
    if ($section == 'home') {
        header("Location: ../index.php?s=home");
    } else {
        header("Location: ../index.php?s=profile&id=$id_user");
    }
} else {
    $_SESSION['old_data'] = $_POST;
    $_SESSION['status_error'] = print_r($success);
  
    if ($section == 'home') {
        header("Location: ../index.php?s=home");
    } else {
        header("Location: ../index.php?s=profile&id=$id_user");
    }
}
