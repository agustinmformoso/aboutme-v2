<?php
require_once '../data/bootstrap.php';
require_once '../libraries/likes.php';

$id_post    = $_GET['id_post'];
$section = $_GET['s'];
$id_user = $_GET['id_user'];

$success = like($db, [
    'id_post' => $id_post,
    'id_user'   => $id_user,
]);

if ($success) {
    $_SESSION['status_success'] = "¡Post likeado con éxito!";

    redirect($section, $id_user);
} else {
    $_SESSION['status_error'] = 'Ha ocurrido un error al likear el post. Por favor, intenta de nuevo más tarde. Si el problema persiste, comunícate con el soporte.';

    redirect($section, $id_user);
}
