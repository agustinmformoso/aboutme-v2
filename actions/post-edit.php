<?php
require_once '../data/bootstrap.php';
require_once '../libraries/posts.php';
require_once '../libraries/auth.php';

$section    = $_GET['s'];
$id         = $_GET['id'];
$id_user    = $_GET['id_user'];
$id_post    = $_GET['id_post'];

$type       = trim($_POST['type']);
$title      = trim($_POST['title']);
$content    = trim($_POST['content']);
$rating     = trim($_POST['rating']);

$success = postEdit($db, [
    'id_post'   => $id_post,
    'type'      => $type,
    'title'     => $title,
    'content'   => $content,
    'rating'    => $rating ? $rating : 0,
]);

if ($success) {
    $_SESSION['status_success'] = "¡Post editado con éxito!";

    redirect($section, $id);
} else {
    $_SESSION['old_data'] = $_POST;
    $_SESSION['status_error'] = "Ha ocurrido un error al editar el post. Por favor, intenta de nuevo más tarde. Si el problema persiste, comunícate con el soporte.";

    redirect($section, $id);
}
