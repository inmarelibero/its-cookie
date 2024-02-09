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

function tryChangePassword(string $email, ?string $plainPassword) {
    if(!isUserExisting($email)){
        throw new Exception ("l'email non esiste");
    }

    //ERRORE PASSWORD TROPPO CORTA
    if($plainPassword === null || strlen($plainPassword) < 3){
        throw new Exception ("Password troppo corta");
    }

    $data = readCredentials();

    // PRENDERE L'UTENTE A CUI VOGLIO AGGIORNARE LA PASSWORD
    foreach ($data as $index => $credentials){
        $emailCredentials = $credentials[0];
        if ($emailCredentials === $email) {
            // AGGIORNO LA PASSWORD DI QUELL'UTENTE
            $data[$index][1] = md5($plainPassword);
        }
    }

    // MEMORIZZO I CAMBIAMENTI DEL FILE USER.CSV
    persistUsers($data);   
}

function tryRegisterUser(?string $email, ?string $plainPassword){
    $data = readCredentials();
    $data[] = [$email, $plainPassword];
    persistUsers($data);
}

/**
 * 
 */
function persistUsers(array $users){
    // var_dump($users);die;
    $fp = fopen('users.csv', 'w');
    
    foreach($users as $user){
        fputcsv($fp, $user);
    }

    fclose($fp);
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
 * Restituisce un array di credenziali utente in cui ogni elemento ha il formato: 
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
 * $password è la password in chiaro passata dal form di login
 */
function findUser(?string $email, ?string $plainPassword): bool
{
    $data = readCredentials();
    
    foreach($data as $credentials){
        $credentialEmail = $credentials[0];
        $encryptedCredentialPassword = $credentials[1];
        
        if ($email === $credentialEmail){
            if (md5($plainPassword) === $encryptedCredentialPassword){
                return true;
            }

            throw new Exception("Password sbagliata");
        }
    }

    throw new Exception("Email non trovata");
}

function isUserExisting (string $email): bool
{
    $data = readCredentials();
    
    foreach($data as $credentials){
        $credentialEmail = $credentials[0];
        if ($email === $credentialEmail){
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
function writeLogVisitedPage()
{
    // sapere data/ora
    $date = date('Y-m-d H:i:s');

    // sapere path della pagina
    $path = $_SERVER['REQUEST_URI'];

    // costruisco la stringa log da scrivere nel file logs.txt
    $logMessage = '[' . $date . '] pagina visitata ' . $path;

    // aggiungere il log al file logs.txt (creare il file se non esiste)
    file_put_contents(__DIR__.'/logs.txt', $logMessage.PHP_EOL , FILE_APPEND | LOCK_EX);
}