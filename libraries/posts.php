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

/**
 * Returns the post by the $id.
 *
 * @param mysqli $db
 * @param mixed $id
 * @return array
 */
function getPostById($db, $id)
{
    $id = mysqli_real_escape_string($db, $id);
    $query = "SELECT p.* FROM posts p
              WHERE p.id_user = '" . $id . "'";

    $res = mysqli_query($db, $query);

    $output = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    return $output;
}
