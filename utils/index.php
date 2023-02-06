<?php

function isLiked($likes, $id_user)
{
    foreach ($likes as $like) {
        if ($like['id_user'] == $id_user) {
            return 'liked';
        }
    }
}
