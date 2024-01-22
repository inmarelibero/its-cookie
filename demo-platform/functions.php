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
function isUserAuthenticated(): bool
{
    if (empty($_SESSION['email'])) {
        return false;
    }

    return true;
}

/**
 * 
 */
function getEmailOfAuthenticatedUser(): ?string
{
    if (isUserAuthenticated()){
        return $_SESSION['email'];
    }
    return null;
}

/**
 * 
 */
function tryLogin(?string $email, ?string $password): bool
{
    if (empty($email)){
        return false;
    }

    $emailFormatted = getTrimAndLowerCase($email);

    if (findUser($emailFormatted, $password) === true) {
        // autentica l'utente usando la sessione
        $_SESSION['email'] = $emailFormatted;

        return true;
    }
    
    return false;
}

/**
 * 
 */
function getTrimAndLowerCase(string $input): string {
    $output = strtolower ($input);
    $output = trim ($output);

    return $output;
}

/**
 * Restituisce un array di credenziali utente in cui gni elementoha il formato: 
 *  [
 *      [
 *          0 => email,
 *          1 => password
 *      ],
 *      ...
 *  ]
 * 
 */
function readCredentials() :array{
    
    $csvFile = file(__DIR__.'/users.csv');
    $data = [];

    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }

    return $data;
}

/**
 * $email dev'essere già lowercase e senza spazi
 */
function findUser(?string $email, ?string $password): bool
{
    $data = readCredentials();
    
    foreach($data as $credentials){
        $credentialEmail = $credentials[0];
        $credentialPassword = $credentials[1];
        
        if ($email === $credentialEmail){
            if ($password === $credentialPassword){
                return true;
            }

            throw new Exception("Password sbagliata");
        }
    }

    throw new Exception("Email non trovata");
}

/**
 * 
 */
function redirectTo($path = 'homepage.php')
{
    header("Location: ".$path);
    exit();
}

function redirectToHome()
{
    redirectTo();
}

/**
 * 
 */
function redirectIfNotAuthenticated()
{
    if (!isUserAuthenticated) {
        redirectTo('login.php');
    }
}