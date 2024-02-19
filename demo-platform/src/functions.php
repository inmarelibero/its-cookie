<?php

/**
 * Return true if user is authenticated
 *
 * @return bool
 */
function isUserAuthenticated(): bool
{
    return !empty($_SESSION['email']);
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
 * 
 */
function tryLogin(?string $email, ?string $password): User
{
    if (empty($email)) {
        throw new Exception("Email vuota");
    }

    $foundUser = findUser($email, $password);

    // autentica l'utente usando la sessione
    $_SESSION['email'] = $foundUser->getEmail();

    $logger = new Logger();
    $logger->writeLogUserLogin($email);

    return $foundUser;
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

    $users = readCredentials();

    // PRENDERE L'UTENTE A CUI VOGLIO AGGIORNARE LA PASSWORD
    foreach ($users as $index => $user) {
        if ($user->getEmail() === $email) {
            // AGGIORNO LA PASSWORD DI QUELL'UTENTE
            $user->setEncryptedPassword(
                md5($plainPassword)
            );
        }
    }

    // MEMORIZZO I CAMBIAMENTI DEL FILE USER.CSV
    persistUsers($users);   
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
    // ERRORE PASSWORD TROPPO CORTA
    if ($plainPassword === null || strlen($plainPassword) < 3) {
        throw new Exception ("Password troppo corta");
    }

    if (isUserExisting($email)) {
        throw new Exception ("Esiste già un utente con questa email");
    }

    $users = readCredentials();

    // AGGIUNGO L'UTENTE
    $newUser = new User($email, md5($plainPassword));
    $users[] = $newUser;

    // MEMORIZZO I CAMBIAMENTI DEL FILE USER.CSV
    persistUsers($users);

    return $newUser;
}

/**
 * 
 */
function persistUsers(array $users)
{
    $fp = fopen(__DIR__.'/../users.csv', 'w');
    
    foreach($users as $user) {
        $line = [$user->getEmail(), $user->getEncryptedPassword(),];

        fputcsv($fp, $line);
    }

    fclose($fp);
}

/**
 * 
 */
function getTrimAndLowerCase(string $input): string
{
    $output = strtolower($input);
    $output = trim($output);

    return $output;
}

/**
 * Restituisce un array di oggetti User
 *  */
function readCredentials(): array
{
    $UsersCsvPath = __DIR__.'/../users.csv';
    
    if (!file_exists($UsersCsvPath)) {
        return [];
    }

    $csvFile = file($UsersCsvPath);
    $data = [];

    foreach ($csvFile as $line) {
        $lineAsArray = str_getcsv($line);

        $user = new User($lineAsArray[0], $lineAsArray[1]);
        $data[] = $user;
    }

    return $data;
}

/**
 * $email dev'essere già lowercase e senza spazi
 * $password è la password in chiaro passata dal form di login
 */
function findUser(?string $email, ?string $plainPassword): User
{
    $emailFormatted = getTrimAndLowerCase($email);

    $users = readCredentials();
    
    foreach($users as $user) {
        if ($emailFormatted === $user->getEmail()) {
            if (md5($plainPassword) === $user->getEncryptedPassword()) {
                return $user;
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
    $users = readCredentials();
    
    foreach($users as $user) {
        if ($email === $user->getEmail()) {
            return true;
        }
    }

    return false; 
}
