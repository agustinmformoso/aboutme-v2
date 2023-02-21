<?php
require '../data/bootstrap.php';
require '../libraries/comments.php';

$id = $_GET['id'];
$section = $_GET['s'];
$id_user = $_GET['id_user'];
$id_comment = $_GET['id_comment'];

$success = commentDelete($db, $id_comment);

if ($success) {
    $_SESSION['status_success'] = "¡El comentario fue eliminado exitosamente!";

    redirect($section, $id);
} else {
    $_SESSION['status_error'] = "Ha ocurrido un error al eliminar el comentario. Por favor, intenta de nuevo más tarde. Si el problema persiste, comunícate con el soporte.";

    redirect($section, $id);
}
