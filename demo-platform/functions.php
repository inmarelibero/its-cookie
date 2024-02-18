<?php

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
    if (isUserAuthenticated()) {
        return $_SESSION['email'];
    }

    return null;
}

/**
 * @todo return User
 */
function tryLogin(?string $email, ?string $password): User
{
    if (empty($email)) {
        throw new Exception("Email vuota");
    }

    $emailFormatted = getTrimAndLowerCase($email);

    if (findUser($emailFormatted, $password) === true) {
        // autentica l'utente usando la sessione
        $_SESSION['email'] = $emailFormatted;

        $logger = new Logger();
        $logger->writeLogUserLogin($emailFormatted);

        return true;
    }

    throw new Exception("Utente non trovato");
}

/**
 * @param string $email
 * @param string|null $plainPassword
 * @return void
 * @throws Exception
 */
function tryChangePassword(string $email, ?string $plainPassword)
{
    if (!isUserExisting($email)) {
        throw new Exception ("l'email non esiste");
    }

    //ERRORE PASSWORD TROPPO CORTA
    if ($plainPassword === null || strlen($plainPassword) < 3) {
        throw new Exception ("Password troppo corta");
    }

    $data = readCredentials();

    // PRENDERE L'UTENTE A CUI VOGLIO AGGIORNARE LA PASSWORD
    foreach ($data as $index => $credentials) {
        $emailCredentials = $credentials[0];
        if ($emailCredentials === $email) {
            // AGGIORNO LA PASSWORD DI QUELL'UTENTE
            $data[$index][1] = md5($plainPassword);
        }
    }

    // MEMORIZZO I CAMBIAMENTI DEL FILE USER.CSV
    persistUsers($data);   
}

/**
 *
 * @todo return User
 * @param string|null $email
 * @param string|null $plainPassword
 * @return bool
 * @throws Exception
 */
function tryRegisterUser(?string $email, ?string $plainPassword): User
{
    //ERRORE PASSWORD TROPPO CORTA
    if ($plainPassword === null || strlen($plainPassword) < 3) {
        throw new Exception ("Password troppo corta");
    }

    if (isUserExisting($email)) {
        throw new Exception ("Esiste già un utente con questa email");
    }

    $data = readCredentials();

    // AGGIUNGO L'UTENTE
    $data[] = [$email, md5($plainPassword)];

    // MEMORIZZO I CAMBIAMENTI DEL FILE USER.CSV
    persistUsers($data);

    return true;
}

/**
 * @todo $users must be an array of User instances
 */
function persistUsers(array $users)
    {
    $fp = fopen('users.csv', 'w');
    
    foreach($users as $user) {
        fputcsv($fp, $user);
    }

    fclose($fp);
}

/**
 * 
 */
function getTrimAndLowerCase(string $input): string
{
    $output = strtolower ($input);
    $output = trim ($output);

    return $output;
}

/**
 * Restituisce un array di credenziali utente in cui ogni elemento ha il formato: 
 *  [
 *      [
 *          0 => email,
 *          1 => password
 *      ],
 *      ...
 *  ]
 * 
 * @todo return array of User instances
 */
function readCredentials(): array
{
    
    $csvFile = file(__DIR__.'/users.csv');
    $data = [];

    foreach ($csvFile as $line) {
        $data[] = str_getcsv($line);
    }

    return $data;
}

/**
 * $email dev'essere già lowercase e senza spazi
 * $password è la password in chiaro passata dal form di login
 *
 * @todo return User
 */
function findUser(?string $email, ?string $plainPassword): User
{
    $data = readCredentials();
    
    foreach($data as $credentials) {
        $credentialEmail = $credentials[0];
        $encryptedCredentialPassword = $credentials[1];
        
        if ($email === $credentialEmail) {
            if (md5($plainPassword) === $encryptedCredentialPassword) {
                return true;
            }

            throw new Exception("Password sbagliata");
        }
    }

    throw new Exception("Email non trovata");
}

/**
 * @param string $email
 * @return bool
 */
function isUserExisting (string $email): bool
{
    $data = readCredentials();
    
    foreach($data as $credentials) {
        $credentialEmail = $credentials[0];
        if ($email === $credentialEmail) {
            return true;
        }
    }

    return false; 
}

/**
 * 
 */
function redirectTo($path = 'homepage.php')
{
    header("Location: ".$path);
    exit();
}

/**
 * @return void
 */
function redirectToHome()
{
    redirectTo();
}

/**
 * 
 */
function redirectIfNotAuthenticated()
{
    if (!isUserAuthenticated()) {
        redirectTo('login.php');
    }
}

/**
 *
 */
function redirectIfAuthenticated($path = '/homepage.php')
{
    if (isUserAuthenticated()) {
        redirectTo($path);
    }
}
