<?php

/**
 * Returns the likes by the $id.
 *
 * @param mysqli $db
 * @param mixed $id
 * @return array
 */
function likesGetById($db, $id)
{
    $id = mysqli_real_escape_string($db, $id);
    $query = "SELECT l.* FROM likes l WHERE l.id_post = '" . $id . "'";

    $res = mysqli_query($db, $query);

    $output = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    return $output;
}

/**
 * Returns the likes by the $id.
 *
 * @param mysqli $db
 * @param mixed $id
 * @return array
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
 * TODO
 *
 * @param mysqli $db
 * @param int $id
 * @return bool
 */
function like($db, $data)
{
    $id_post = mysqli_real_escape_string($db, $data['id_post']);
    $id_user = mysqli_real_escape_string($db, $data['id_user']);

    $query = "INSERT INTO likes (id_post, id_user) VALUES ($id_post, $id_user)";
    $success = mysqli_query($db, $query);

    if ($success) {
        return mysqli_insert_id($db);
    }

    return false;
}


/**
 * TODO
 *
 * @param mysqli $db
 * @param int $id
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
 * TODO
 *
 * @param mysqli $db
 * @param mixed $id
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
