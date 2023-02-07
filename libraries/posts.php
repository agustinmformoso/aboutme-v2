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

/**
 * Creates a posts.
 *
 * @param mysqli $db
 * @param mixed $id
 * @return array
 */
function createPost($db, $data)
{
    $id_user = mysqli_real_escape_string($db, $data['id_user'] ?? '');
    $type = mysqli_real_escape_string($db, $data['type'] ?? '');
    $title = mysqli_real_escape_string($db, $data['title'] ?? '');
    $content = mysqli_real_escape_string($db, $data['content'] ?? '');
    $rating = mysqli_real_escape_string($db, $data['rating'] ?? '');

    $image = ''; // @TODO - - - > Image Update
    $alt_image = '';  // @TODO - - - > Image Update

    $query = "INSERT INTO posts (title, content, rating, type, image, alt_image, id_user)
              VALUES ('" . $title . "', '" . $content . "', '" . $rating . "', '" . $type . "', '" . $image . "', '" . $alt_image . "', '" . $id_user . "')";
    $success = mysqli_query($db, $query);

    if ($success) {
        mysqli_insert_id($db);
    }

    return $success;
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

    $query = "DELETE FROM posts
              WHERE id_post = '" . $id . "'";

    $success = mysqli_query($db, $query);

    return $success;
}
