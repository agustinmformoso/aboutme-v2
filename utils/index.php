<?php

function redirect($section, $id_user)
{
    if ($section == 'home') {
        header("Location: ../index.php?s=home");
    } else if ($section == 'liked-posts') {
        header("Location: ../index.php?s=liked-posts&id=$id_user");
    } else {
        header("Location: ../index.php?s=profile&id=$id_user");
    }
}
