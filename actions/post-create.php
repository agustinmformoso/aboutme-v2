<?php
require_once '../data/bootstrap.php';
require_once '../libraries/posts.php';
require_once '../libraries/auth.php';

// @TODO - - > REVIEW;

$id_user    = $_GET['id'];
$section    = $_GET['s'];
$id_user    = $_GET['id_user'];
$type       = trim($_POST['type']);
$title      = trim($_POST['title']);
$content    = trim($_POST['content']);
$rating     = trim($_POST['rating']);

function redirect($section, $id_user)
{
    if ($section == 'home') {
        header("Location: ../index.php?s=home");
    } else {
        header("Location: ../index.php?s=profile&id=$id_user");
    }
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
    
    redirect($section, $id_user);
} else {
    $_SESSION['old_data'] = $_POST;
    $_SESSION['status_error'] = print_r($success); // @TODO - - > REVIEW
  
    redirect($section, $id_user);
}
