<?php

/**
 * Returns the post by the $id.
 *
 * @param mysqli $db
 * @param mixed $id
 * @return array
 */
function getAllPosts($db)
{
    $query = "SELECT p.* FROM posts p";

    $res = mysqli_query($db, $query);

    $output = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    return $output;
}
