<?php

/**
 * Returns a list of likes by id post.
 *
 * @param mysqli $db
 * @param int $id_post
 * @return array
 */
function likesGetById($db, $id_post)
{
    $id_post = mysqli_real_escape_string($db, $id_post);
    $query = "SELECT l.* FROM likes l WHERE l.id_post = '" . $id_post . "'";

    $res = mysqli_query($db, $query);

    $output = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    return $output;
}

/**
 * Checks if the post is liked by the user.
 *
 * @param mysqli $db
 * @param int $id_user
 * @param int $id_post
 * @return bool
 */
function isLiked($db, $id_user, $id_post)
{
    $id_user = mysqli_real_escape_string($db, $id_user);
    $id_post = mysqli_real_escape_string($db, $id_post);

    $query = "SELECT l.* FROM likes l WHERE l.id_post = '" . $id_post . "' AND l.id_user = '" . $id_user . "'";

    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row === false) {
        return false;
    }

    return $row;
}

/**
 * Add a like the the likes table passing the id_post and id_user as parameter.
 *
 * @param mysqli $db
 * @param array $data
 * @return bool
 */
function like($db, $data)
{
    $id_post = mysqli_real_escape_string($db, $data['id_post']);
    $id_user = mysqli_real_escape_string($db, $data['id_user']);

    $query = "INSERT INTO likes (id_post, id_user) VALUES ($id_post, $id_user)";
    $success = mysqli_query($db, $query);

    if ($success) {
        mysqli_insert_id($db);

        return $success;
    }

    return false;
}


/**
 * Remove a like passing the id_like as parameter.
 *
 * @param mysqli $db
 * @param int $id_like
 * @return bool
 */
function removeLike($db, $data)
{
    $id_like = mysqli_real_escape_string($db, $data['id_like']);

    $query = "DELETE FROM likes
              WHERE id_like = '" . $id_like . "'";

    $success = mysqli_query($db, $query);

    if ($success) {
        return true;
    }

    return false;
}


/**
 * Searches user likes passing the user_id as parameter.
 *
 * @param mysqli $db
 * @param int $id_user
 * @return array
 */
function getUserLikesById($db, $id_user)
{
    $id_user = mysqli_real_escape_string($db, $id_user);
    $query = "SELECT l.* FROM likes l WHERE l.id_user = '" . $id_user . "'";

    $res = mysqli_query($db, $query);

    $output = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    return $output;
}
