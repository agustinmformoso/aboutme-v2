<?php
require_once __DIR__ . '/users.php';

/**
 * Marks the last user with the $userData data as authenticated.
 *
 * @param array $userData
 */
function authSetLogin($userData)
{
    $_SESSION['user_admin'] = $userData;
}

/**
 * Tries to authenticate the user with the provided credentials.
 *
 * @param mysqli $db
 * @param string $email
 * @param string $password
 * @return bool
 */
function authLogin($db, $email, $password)
{
    $user = getUserByEmail($db, $email);

    if ($user !== null) {
        if (password_verify($password, $user['password'])) {
            authSetLogin([
                'id_user' => $user['id_user'],
                'email' => $user['email'],
                'name' => $user['name'],
                'username' => $user['username'],
                'biography' => $user['biography'],
                'location' => $user['location'],
                'birthdate' => $user['birthdate'],
                'creation_date' => $user['creation_date'],
                'profile_picture' => $user['profile_picture'],
                'profile_picture_alt' => $user['profile_picture_alt'],
                'banner_picture' => $user['banner_picture'],
                'banner_picture_alt' => $user['banner_picture_alt'],
                'role' => $user['role'],
            ]);
            return true;
        }
    }

    return false;
}

/**
 * Tries to authenticate the user with the provided credentials.
 *
 * @param mysqli $db
 * @param string $email
 * @param string $name
 * @param string $lastname
 * @param string $address
 * @return bool
 */
function authUpdate($db, $email)
{
    $user = getUserByEmail($db, $email);

    if ($user !== null) {
        authSetLogin([
            'id_user' => $user['id_user'],
            'email' => $user['email'],
            'name' => $user['name'],
            'username' => $user['username'],
            'biography' => $user['biography'],
            'location' => $user['location'],
            'birthdate' => $user['birthdate'],
            'creation_date' => $user['creation_date'],
            'profile_picture' => $user['profile_picture'],
            'profile_picture_alt' => $user['profile_picture_alt'],
            'banner_picture' => $user['banner_picture'],
            'banner_picture_alt' => $user['banner_picture_alt'],
            'role' => $user['role'],
        ]);
        return true;
    }

    return false;
}

/**
 * Logout the user.
 */
function authLogout()
{
    unset($_SESSION['user_admin']);
}

/**
 * Returns true if the user is authenticated, or false otherwise.
 *
 * @return bool
 */
function authIsAutenticated()
{
    return isset($_SESSION['user_admin']);
}

/**
 * Returns true if the user is an administrator.
 * If not, it returns false.
 *
 * @return bool
 */
function authIsAdmin()
{
    return $_SESSION['user_admin']['role'] == 1;
}

/**
 * Returns an array with the authenticated user data.
 *
 * @return array
 */
function authGetUser()
{
    return $_SESSION['user_admin'];
}
