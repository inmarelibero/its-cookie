<?php

/**
 * Return true if the user with email = $email was authenticated
 *
 * @param string $email
 * @return bool
 */
function isUserWithEmailAuthenticated(string $email): bool
{
    if (empty($_SESSION['email'])) {
        return false;

    }

    return strtolower($_SESSION['email']) === strtolower($email);
}
