<?php

/**
 * Returns the value of a session variable with the supplied key, then removes that variable from the session.
 * If it doesen't exist returns $default.
 *
 * @param string $key key of the requested session variable.
 * @param mixed|null $default default value to return if $key doesn't exist. Default return: null.
 * @return mixed|null
 */
function sessionGetFlashValue($key, $default = null)
{
    if (isset($_SESSION[$key])) {
        $returnValue = $_SESSION[$key];
        unset($_SESSION[$key]);
    } else {
        $returnValue = $default;
    }
    return $returnValue;
}
