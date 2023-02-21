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

/**
 * Creates a posts.
 *
 * @param mysqli $db
 * @param mixed $id
 * @return bool
 */
function createComment($db, $data)
{
    $id_user = mysqli_real_escape_string($db, $data['id_user'] ?? '');
    $id_post = mysqli_real_escape_string($db, $data['id_post'] ?? '');
    $comment_content = mysqli_real_escape_string($db, $data['comment'] ?? '');

    $query = "INSERT INTO comments (comment_content, id_user, id_post)
              VALUES ('" . $comment_content . "', '" . $id_user . "', '" . $id_post . "')";
    $success = mysqli_query($db, $query);

    if ($success) {
        mysqli_insert_id($db);

        return $success;
    }

    return false;
}
