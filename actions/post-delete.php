<?php
require '../data/bootstrap.php';
require '../libraries/posts.php';

$id = $_GET['id'];
$section = $_GET['s'];
$id_user = $_GET['id_user'];

$success = postDelete($db, $id);

function redirect()
{
    // @TODO - - > Redirect
}

if ($success) {
    $_SESSION['status_success'] = "¡El post fue eliminado exitosamente!";
  
    if ($section == 'home') {
        header("Location: ../index.php?s=home");
    } else {
        header("Location: ../index.php?s=profile&id=$id_user");
    }
} else {
    $_SESSION['status_error'] = "Ha ocurrido un error al eliminar el post. Por favor, intenta de nuevo más tarde. Si el problema persiste, comunícate con el soporte.";
   
    if ($section == 'home') {
        header("Location: ../index.php?s=home");
    } else {
        header("Location: ../index.php?s=profile&id=$id_user");
    }
}
