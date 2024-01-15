<?php

/**
 * Return true if the user with email = $email was authenticated
 *
 * @param string $email
 * @return bo
 */
function isUserWithEmailAuthenticated(string $email): bool
{
    if (empty($_SESSION['email'])) {
        return false;
    }

    return strtolower($_SESSION['email']) === strtolower($email);
}

/**
 * Return true if user is authenticated
 *
 * @return bool
 */
function isUserAuthenticated(): bool {
    if (empty($_SESSION['email'])) {
        return false;
    }

    return true;
}

function getEmailOfAuthenticatedUser(): ?string{
    if (isUserAuthenticated()){
        return $_SESSION['email'];
    }
    return null;
}