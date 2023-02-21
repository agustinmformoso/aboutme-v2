<?php
require_once '../data/bootstrap.php';
require_once '../libraries/comments.php';
require_once '../libraries/auth.php';

$section    = $_GET['s'];
$id_user    = $_GET['id_user'];
$id         = $_GET['id'];

$id_post    = $_GET['id_post'];
$comment    = trim($_POST['comment']);

$errors = [];

if (empty($comment)) {
    $errors['comment'] = "El comentario está vacío.";
}

if (!empty($errors)) {
    $_SESSION['old_data'] = $_POST;
    $_SESSION['errors'] = $errors;
    redirect($section, $id_user);
    exit;
}

$success = createComment($db, [
    'id_user'   => $id_user,
    'id_post'   => $id_post,
    'comment'   => $comment,
]);

if ($success) {
    $_SESSION['status_success'] = "Comentario creado con éxito!";

    redirect($section, $id);
} else {
    $_SESSION['old_data'] = $_POST;
    $_SESSION['status_error'] = "Ha ocurrido un error al crear el comentario. Por favor, intenta de nuevo más tarde. Si el problema persiste, comunícate con el soporte.";

    redirect($section, $id);
}
