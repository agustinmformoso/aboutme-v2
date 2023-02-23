<?php
require_once __DIR__ . '/auth.php';

/**
 * Searches for a user by email in the database.
 * If found it, it returns an array with the registry data.
 * Otherwise it returns null.
 *
 * @param mysqli $db
 * @param string $email
 * @return array|null
 */
function getUserByEmail($db, $email)
{
    $email = mysqli_real_escape_string($db, $email);

    $query = "SELECT * FROM users
              WHERE email = '" . $email . "'";
    $res = mysqli_query($db, $query);

    if ($row = mysqli_fetch_assoc($res)) {
        return $row;
    } else {
        return null;
    }
}

/**
 * Searches for a user by id_user in the database.
 * If found it, it returns an array with the registry data.
 * Otherwise it returns null.
 *
 * @param mysqli $db
 * @param string $id_user
 * @return array|null
 */
function getUserById($db, $id_user)
{
    $query = "SELECT * FROM users
              WHERE id_user = '" . $id_user . "'";
    $res = mysqli_query($db, $query);

    if ($row = mysqli_fetch_assoc($res)) {
        return $row;
    } else {
        return null;
    }
}

/**
 * Creates a new user in the database with the $data provided.
 * If sucessful, it returns the id of the created user.
 * If not, it returns false.
 *
 * @param mysqli $db
 * @param array $data
 * @return bool|int
 */
function userCreate($db, $data)
{
    $username   = mysqli_real_escape_string($db, $data['username']);
    $name       = mysqli_real_escape_string($db, $data['name']);
    $email      = mysqli_real_escape_string($db, $data['email']);
    $password   = password_hash($data['password'], PASSWORD_DEFAULT);
    $birthdate  = mysqli_real_escape_string($db, $data['birthdate']);
    $location   = mysqli_real_escape_string($db, $data['location']);
    $biography  = mysqli_real_escape_string($db, $data['biography']);
    $profile_picture   = mysqli_real_escape_string($db, $data['profile_picture']);
    $profile_picture_alt  = mysqli_real_escape_string($db, $data['profile_picture_alt']);

    $profile_picture = 'default-profile.png';
    $profile_picture_alt = 'Default profile picture';

    $query = "INSERT INTO users (username, name, biography, location, birthdate, email, profile_picture, profile_picture_alt, password)
              VALUES ('" . $username . "', '" . $name . "', '" . $biography . "', '" . $location . "', '" . $birthdate . "', '" . $email . "', '" . $profile_picture . "', '" . $profile_picture_alt . "', '" . $password . "')";

    $success = mysqli_query($db, $query);

    if ($success) {
        return mysqli_insert_id($db);
    }

    return false;
}

/**
 * Edit a new user in the database with the $data provided.
 * If sucessful, it returns the id of the created user.
 * If not, it returns false.
 *
 * @param mysqli $db
 * @param mixed $data
 * @return bool|int
 */
function userEdit($db, $data)
{
    $id_user    = mysqli_real_escape_string($db, $data['id_user']);
    $email      = mysqli_real_escape_string($db, $data['email']);
    $username   = mysqli_real_escape_string($db, $data['username']);
    $name       = mysqli_real_escape_string($db, $data['name']);
    $location   = mysqli_real_escape_string($db, $data['location']);
    $biography  = mysqli_real_escape_string($db, $data['biography']);
    $profile_picture   = mysqli_real_escape_string($db, $data['profile_picture']);
    $profile_picture_alt  = mysqli_real_escape_string($db, $data['profile_picture_alt']);
    $banner_picture   = mysqli_real_escape_string($db, $data['banner_picture']);
    $banner_picture_alt  = mysqli_real_escape_string($db, $data['banner_picture_alt']);

    $query = "UPDATE users
                SET   name                 = '" . $name . "',
                      username             = '" . $username . "',
                      location             = '" . $location . "',
                      biography            = '" . $biography . "',
                      profile_picture      = '" . $profile_picture . "',
                      profile_picture_alt  = '" . $profile_picture_alt . "',
                      banner_picture       = '" . $banner_picture . "',
                      banner_picture_alt   = '" . $banner_picture_alt . "'
                WHERE id_user     = '" . $id_user . "'";

    $success = mysqli_query($db, $query);

    if ($success) {
        authUpdate($db, $email);

        return true;
    }

    return false;
}

/**
 * Generates a cryptographically secure token to reset the password.
 * Saves it in the database associated with the user and returns it.
 *
 * @param mysqli $db
 * @param int|string $id
 * @return string|bool
 */
function userGenerateResetToken($db, $id)
{
    $token = openssl_random_pseudo_bytes(32);

    $token = bin2hex($token);

    $expiryDate = time() + 3600;
    $expiryDate = date("Y-m-d H:i:s", $expiryDate);

    $query = "INSERT INTO password_reset (id_user, token, expiry_date)
              VALUES ('" . $id . "', '" . $token . "', '" . $expiryDate . "')";

    $success = mysqli_query($db, $query);

    if (!$success) {
        return false;
    }

    return $token;
}


/**
 * Checks if the $token corresponds to the $email user $token and if is not expired.
 * If true, it returns the user data.
 * Otherwise, returns false.
 *
 * @param mysqli $db
 * @param string $token
 * @param string $email
 * @return array|bool
 */
function userResetTokenIsValid($db, $token, $email)
{
    $token = mysqli_real_escape_string($db, $token);
    $email = mysqli_real_escape_string($db, $email);

    $query = "SELECT * FROM users u
                INNER JOIN password_reset pr
                ON u.id_user = pr.id_user
                WHERE pr.token = '" . $token . "'
                AND u.email = '" . $email . "'
                AND pr.expiry_date >= NOW()";
    $result = mysqli_query($db, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row === false) {
        return false;
    }

    return $row;
}

/**
 * Updates the user's password.
 *
 * @param mysqli $db
 * @param int|string $id
 * @param string $password
 * @return bool|mysqli_result
 */
function userUpdatePassword($db, $id, $password)
{
    $id = mysqli_real_escape_string($db, $id);
    $password = password_hash($password, PASSWORD_DEFAULT);

    $query = "UPDATE users
                SET password = '" . $password . "'
                WHERE id_user = '" . $id . "'";
    $success = mysqli_query($db, $query);

    return $success;
}

/**
 * Deletes the $token from password_reset.
 *
 * @param mysqli $db
 * @param string $token
 * @return bool|mysqli_result
 */
function userDeleteToken($db, $token)
{
    $token = mysqli_real_escape_string($db, $token);

    $query = "DELETE FROM password_reset
              WHERE token = '" . $token . "'";
    $success = mysqli_query($db, $query);

    return $success;
}

/**
 * Deletes the $token from password_reset.
 *
 * @param mysqli $db
 * @param string $token
 * @return bool|mysqli_result
 */
function userGetTokenById($db, $id)
{
    $id = mysqli_real_escape_string($db, $id);

    $query = "SELECT token FROM password_reset
              WHERE id_user = '" . $id . "'";
    $res = mysqli_query($db, $query);

    if ($row = mysqli_fetch_assoc($res)) {
        return $_SESSION['token'] = $row['token'];
    }

    return false;
}
