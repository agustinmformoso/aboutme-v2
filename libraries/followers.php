<?php

/**
 * Returns the followers by the $id.
 *
 * @param mysqli $db
 * @param mixed $id
 * @return array
 */
function getFollowersById($db, $id)
{
    $id = mysqli_real_escape_string($db, $id);
    $query = "SELECT f.* FROM followers f WHERE f.id_user = '" . $id . "'";

    $res = mysqli_query($db, $query);

    $output = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    return $output;
}

/**
 * Returns the followings by the $id.
 *
 * @param mysqli $db
 * @param mixed $id
 * @return array
 */
function getFollowingById($db, $id)
{
    $id = mysqli_real_escape_string($db, $id);
    $query = "SELECT f.* FROM followers f WHERE f.id_follower = '" . $id . "'";

    $res = mysqli_query($db, $query);

    $output = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    return $output;
}

/**
 * TODO
 *
 * @param mysqli $db
 * @param mixed $id
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
 * TODO
 *
 * @param mysqli $db
 * @param mixed $id
 * @return array
 */
function follow($db, $data)
{
    $id_follower = mysqli_real_escape_string($db, $data['id_follower']);
    $id_user = mysqli_real_escape_string($db, $data['id_user']);

    $query = "INSERT INTO followers (id_follower, id_user) VALUES ($id_follower, $id_user)";
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
