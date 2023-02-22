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
function getPostByUserId($db, $id)
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

/**
 * Returns the post by the $id.
 *
 * @param mysqli $db
 * @param mixed $id
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
 * @param mixed $id
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
 * Deletes a post item from the database with the provided $id.
 * Returns true if successful, false otherwise
 *
 * @param mysqli $db
 * @param int $id
 * @return bool
 */
function postDelete($db, $id)
{
    $id = mysqli_real_escape_string($db, $id);

    $query = "DELETE FROM comments
                WHERE id_post = '" . $id . "';
                DELETE FROM posts
                WHERE id_post = '" . $id . "'";

    $success = mysqli_multi_query($db, $query);

    return $success;
}

/**
 * Returns the post by the $id.
 *
 * @param mysqli $db
 * @param mixed $id
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
 * Creates a new user in the database with the $data provided.
 * If sucessful, it returns the id of the created user.
 * If not, it returns false.
 *
 * @param mysqli $db
 * @param mixed $email
 * @param mixed $name
 * @param mixed $lastname
 * @param mixed $address
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
