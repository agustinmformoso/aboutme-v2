<?php

function redirect($section, $id_user)
{
    if ($section == 'home') {
        header("Location: ../index.php?s=home");
    } else {
        header("Location: ../index.php?s=profile&id=$id_user");
    }
}
