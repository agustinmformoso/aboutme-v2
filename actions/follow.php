<?php
require_once '../data/bootstrap.php';
require_once '../libraries/followers.php';

$id_follower    = $_GET['id_follower'];
$id_user        = $_GET['id_user'];

$success = follow($db, [
    'id_follower' => $id_follower,
    'id_user'   => $id_user,
]);

if ($success) {
    $_SESSION['status_success'] = "¡Usuario seguido con éxito!";
    
    header("Location: ../index.php?s=profile&id=$id_user");
} else {
    $_SESSION['status_error'] = 'Ha ocurrido un error al seguir a el usuario. Por favor, intenta de nuevo más tarde. Si el problema persiste, comunícate con el soporte.';
  
    header("Location: ../index.php?s=profile&id=$id_user");
}
