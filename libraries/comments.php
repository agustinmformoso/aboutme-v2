<?php

/**
 * Returns the comments by the $id.
 *
 * @param mysqli $db
 * @param mixed $id
 * @return array
 */
function getCommentsById($db, $id)
{
    $id = mysqli_real_escape_string($db, $id);
    $query = "SELECT c.* FROM comments c WHERE c.id_post = '" . $id . "'";

    $res = mysqli_query($db, $query);

    $output = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    return $output;
}
