<?php

/**
 * Returns the comments passing the post_id as parameter.
 *
 * @param mysqli $db
 * @param mixed $id_post
 * @return array
 */
function getCommentsById($db, $id_post)
{
    $id_post = mysqli_real_escape_string($db, $id_post);
    $query = "SELECT c.* FROM comments c WHERE c.id_post = '" . $id_post . "'";

    $res = mysqli_query($db, $query);

    $output = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    return $output;
}

/**
 * Creates a comment.
 *
 * @param mysqli $db
 * @param mixed $data
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

/**
 * Deletes a comment item from the database with the provided $id.
 * Returns true if successful, false otherwise
 *
 * @param mysqli $db
 * @param int $id
 * @return bool
 */
function commentDelete($db, $id_comment)
{
    $id = mysqli_real_escape_string($db, $id_comment);

    $query = "DELETE FROM comments
              WHERE id_comment = '" . $id_comment . "'";

    $success = mysqli_query($db, $query);

    if (!$success) {
        return false;
    }

    return $success;
}
