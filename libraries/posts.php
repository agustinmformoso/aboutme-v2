<?php

/**
 * Return all posts.
 *
 * @param mysqli $db
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
 * Searches all the post from a user passing the id_user as parameter.
 *
 * @param mysqli $db
 * @param int $id_user
 * @return array
 */
function getPostByUserId($db, $id_user)
{
    $id_user = mysqli_real_escape_string($db, $id_user);
    $query = "SELECT p.* FROM posts p
              WHERE p.id_user = '" . $id_user . "'";

    $res = mysqli_query($db, $query);

    $output = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    return $output;
}

/**
 * Return the post passing the id_post as parameter.
 *
 * @param mysqli $db
 * @param int $id_post
 * @return array
 */
function getPostById($db, $id_post)
{
    $id_post = mysqli_real_escape_string($db, $id_post);

    $query = "SELECT p.* FROM posts p
              WHERE p.id_post = '" . $id_post . "'";

    $res = mysqli_query($db, $query);

    while ($row = mysqli_fetch_assoc($res)) {
        return $row;
    }

    return $row;
}

/**
 * Creates a posts.
 *
 * @param mysqli $db
 * @param mixed $data
 * @return bool
 */
function createPost($db, $data)
{
    $id_user = mysqli_real_escape_string($db, $data['id_user'] ?? '');
    $type = mysqli_real_escape_string($db, $data['type'] ?? '');
    $title = mysqli_real_escape_string($db, $data['title'] ?? '');
    $content = mysqli_real_escape_string($db, $data['content'] ?? '');
    $rating = mysqli_real_escape_string($db, $data['rating'] ?? '');
    $image = mysqli_real_escape_string($db, $data['image']) ? mysqli_real_escape_string($db, $data['image']) : '';
    $alt_image = mysqli_real_escape_string($db, $data['alt_image']) ? mysqli_real_escape_string($db, $data['alt_image']) : '';

    $query = "INSERT INTO posts (title, content, rating, type, image, alt_image, id_user)
              VALUES ('" . $title . "', '" . $content . "', '" . $rating . "', '" . $type . "', '" . $image . "', '" . $alt_image . "', '" . $id_user . "')";
    $success = mysqli_query($db, $query);

    if ($success) {
        mysqli_insert_id($db);

        return $success;
    }

    return false;
}

/**
 * Deletes a post from the database with the provided $id.
 * Returns true if successful, false otherwise
 *
 * @param mysqli $db
 * @param int $id_post
 * @return bool
 */
function postDelete($db, $id_post)
{
    $id_post = mysqli_real_escape_string($db, $id_post);

    $query = "DELETE FROM comments
                WHERE id_post = '" . $id_post . "';
                DELETE FROM posts
                WHERE id_post = '" . $id_post . "'";

    $success = mysqli_multi_query($db, $query);

    if (!$success) {
        return false;
    }

    return $success;
}

/**
 * Returns posts liked by the user.
 *
 * @param mysqli $db
 * @param int $id_user
 * @return array
 */
function getUserLikedPosts($db, $id_user)
{
    $id_user = mysqli_real_escape_string($db, $id_user);
    $query = "SELECT p.* FROM posts p WHERE p.id_post IN ( SELECT l.id_post FROM likes l WHERE l.id_user = '" . $id_user . "' )";

    $res = mysqli_query($db, $query);

    $output = [];

    while ($row = mysqli_fetch_assoc($res)) {
        $output[] = $row;
    }

    return $output;
}

/**
 * Creates a new post in the database with the $data provided.
 * If sucessful, it returns the id of the created user.
 * If not, it returns false.
 *
 * @param mysqli $db
 * @param mixed $data
 * @return bool|int
 */
function postEdit($db, $data)
{
    $id_post    = mysqli_real_escape_string($db, $data['id_post']);
    $type       = mysqli_real_escape_string($db, $data['type']);
    $title      = mysqli_real_escape_string($db, $data['title']);
    $content    = mysqli_real_escape_string($db, $data['content']);
    $rating     = mysqli_real_escape_string($db, $data['rating']);
    $image      = mysqli_real_escape_string($db, $data['image']) ? mysqli_real_escape_string($db, $data['image']) : '';
    $alt_image  = mysqli_real_escape_string($db, $data['alt_image']) ? mysqli_real_escape_string($db, $data['alt_image']) : '';

    $query = "UPDATE posts
                SET   type        = '" . $type . "',
                      title       = '" . $title . "',
                      content     = '" . $content . "',
                      rating      = '" . $rating . "',
                      image       = '" . $image . "',
                      alt_image   = '" . $alt_image . "'
                WHERE id_post     = '" . $id_post . "'";

    $success = mysqli_query($db, $query);

    if ($success) {
        return ($success);
    }

    return false;
}
