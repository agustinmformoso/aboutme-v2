<?php
require_once '../data/bootstrap.php';
require_once '../libraries/posts.php';
require_once '../libraries/auth.php';

$section    = $_GET['s'];
$id_user    = $_GET['id_user'];
$type       = trim($_POST['type']);
$title      = trim($_POST['title']);
$content    = trim($_POST['content']);
$rating     = trim($_POST['rating']);

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
    $_SESSION['status_error'] = "Ha ocurrido un error al crear el post. Por favor, intenta de nuevo más tarde. Si el problema persiste, comunícate con el soporte.";

    redirect($section, $id_user);
}
