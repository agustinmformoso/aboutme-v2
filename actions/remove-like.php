<?php
require_once '../data/bootstrap.php';
require_once '../libraries/likes.php';

$id_like = $_GET['id_like'];
$section = $_GET['s'];
$id_user = $_GET['id_user'];

$success = removeLike($db, [
    'id_like' => $id_like,
]);

if ($success) {
    $_SESSION['status_success'] = "¡Like removido con éxito!";

    redirect($section, $id_user);
} else {
    $_SESSION['status_error'] = 'Ha ocurrido un error al el like. Por favor, intenta de nuevo más tarde. Si el problema persiste, comunícate con el soporte.';

    redirect($section, $id_user);
}
