<?php

/**
 * Returns the followers by the $id_user.
 *
 * @param mysqli $db
 * @param mixed $id_user
 * @return array
 */
function getFollowersById($db, $id_user)
{
    $id_user = mysqli_real_escape_string($db, $id_user);
    $query = "SELECT f.* FROM followers f WHERE f.id_user = '" . $id_user . "'";

    $res = mysqli_query($db, $query);

    $output = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    return $output;
}

/**
 * Returns the followings by the $id_follower.
 *
 * @param mysqli $db
 * @param mixed $id_follower
 * @return array
 */
function getFollowingById($db, $id_follower)
{
    $id_follower = mysqli_real_escape_string($db, $id_follower);
    $query = "SELECT f.* FROM followers f WHERE f.id_follower = '" . $id_follower . "'";

    $res = mysqli_query($db, $query);

    $output = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    return $output;
}

/**
 * Checks if one user follows another user.
 *
 * @param mysqli $db
 * @param int $id_follower
 * @param int $id_user
 * @return array
 */
function isFollowing($db, $id_follower, $id_user)
{
    $id_user = mysqli_real_escape_string($db, $id_user);
    $id_follower = mysqli_real_escape_string($db, $id_follower);

    $query = "SELECT f.* FROM followers f WHERE f.id_follower = '" . $id_follower . "' AND f.id_user = '" . $id_user . "'";

    $res = mysqli_query($db, $query);

    $output = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    return $output;
}

/**
 * Creates a follower in the followers table.
 *
 * @param mysqli $db
 * @param mixed $data
 * @return bool
 */
function follow($db, $data)
{
    $id_follower = mysqli_real_escape_string($db, $data['id_follower']);
    $id_user = mysqli_real_escape_string($db, $data['id_user']);

    $query = "INSERT INTO followers (id_follower, id_user) VALUES ($id_follower, $id_user)";
    $success = mysqli_query($db, $query);

    if ($success) {
        mysqli_insert_id($db);

        return $success;
    }

    return false;
}

/**
 * Delete a follower passing the id_follower and the id_user as parameter.
 *
 * @param mysqli $db
 * @param mixed $data
 * @return bool
 */
function unfollow($db, $data)
{
    $id_follower = mysqli_real_escape_string($db, $data['id_follower']);
    $id_user = mysqli_real_escape_string($db, $data['id_user']);

    $query = "DELETE FROM followers
              WHERE id_follower = '" . $id_follower . "' AND id_user = '" . $id_user . "'";

    $success = mysqli_query($db, $query);

    if ($success) {
        return true;
    }

    return false;
}
