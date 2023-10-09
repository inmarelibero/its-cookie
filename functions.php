<?php

/**
 * @param $email
 * @param $password
 * @return true|array true if user can be authenticated, an array of strings representing errors if not
 */
function handleLoginForm($email, $password)
{
    // array di errori
    $errors = [];

    if (empty($email)) {
        $errors[] = 'Campo email obbligatorio';
    }

    if (empty($password)) {
        $errors[] = 'Campo password obbligatorio';
    } else {
        if (strlen($password) < 3) {
            $errors[] = 'Password troppo corta';
        }
    }

    if (count($errors) <= 0) {
        if (checkCredentials($email, $password)) {
            return true;
        } else {
            $errors[] = 'Utente e password non trovati';
        }
    }

    return $errors;
}
/**
 * @param $email
 * @param $password
 * @param $passwordConfirm
 * @throws Exception
 * @return true|array true if user can be authenticated, an array of strings representing errors if not
 */
function handleRegistrationForm($email, $password, $passwordConfirm)
{
    if (empty($email)) {
        throw new Exception('Campo email obbligatorio');
    }

    if (empty($password)) {
        throw new Exception('Campo password obbligatorio');
    }

    if (strlen($password) < 3) {
        throw new Exception('Password troppo corta');
    }

    if ($password !== $passwordConfirm) {
        throw new Exception('Le password non coincidono');
    }

    // leggo gli utenti attuali
    $users = getUsers();

    // se l'email esiste già: errore
    if (emailExists($email, $users)) {
        throw new Exception('Email già esistente');
    }

    // inserisco un nuovo utente
    addUser($email, $password);
}

/**
 * @param $email
 * @param array $users
 * @return bool
 */
function emailExists($email, array $users): bool
{
    foreach ($users as $user) {
        if ($user[0] === $email) {
            return true;
        }
    }

    return false;
}

function addUser($email, $password)
{
    $users = getUsers();

    $users[] = [$email, $password];

    saveUsers($users);
}

function saveUsers(array $users)
{
    $usersFilename = buildPathRelativeToDocumentRootParent('users.csv');
    $file = fopen($usersFilename, 'w');

    foreach ($users as $user) {
        fputcsv($file, $user);
    }
}

/**
 * @param $email
 * @param $password
 * @return bool
 */
function checkCredentials($email, $password)
{
    $users = getUsers();

    foreach ($users as $user) {
        if ($email === $user[0] && $password === $user[1]) {
            return true;
        }
    }

    return false;
}

/**
 * @return array
 */
function getUsers()
{
    $usersFilename = buildPathRelativeToDocumentRootParent('users.csv');

    $users = [];

    if (($handle = fopen($usersFilename, "r")) !== FALSE) {
        while (($currentUser = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $users[] = $currentUser;
        }
        fclose($handle);
    }

    return $users;
}

/**
 * @return bool
 */
function isUserAuthenticated()
{
    return array_key_exists('email', $_SESSION);
}

function authenticateUser($email)
{
    $_SESSION['email'] = $email;
}

/**
 * @return string|null
 */
function getEmailOfAuthenticatedUser(): string | null
{
    if (isUserAuthenticated()) {
        return $_SESSION['email'];
    }

    return null;
}

/**
 * @param $path
 * @return void
 */
function redirect($path = 'homepage.php')
{
    header("Location: $path");
    exit;
}

/**
 * @return void
 */
function printHead($metaTitle = 'My website')
{
    require_once('head.php');
}

/**
 * @return void
 */
function redirectIfNotAuthenticated($path = 'homepage.php')
{
    if (!isUserAuthenticated()) {
        redirect($path);
    }
}

/**
 * Build a path by optionally concatenating some query parameters
 *
 * @param string $path
 * @param array $queryParameters key: query parameter name, value: parameter value
 * @return string
 */
function buildPathWithQueryParameters(string $path, array $queryParameters = []): string
{
    /*
     *
     */
    $queryParameters = array_filter($queryParameters, function ($value) {
        return !empty($value);
    });

    /*
     * build query portion
     */
    $query = '';

    if (count($queryParameters) > 0) {
        $query = '?'.http_build_query($queryParameters);
    }

    /*
     * return final path
     */
    return $path . $query;
}

/**
 * Return the value for a specific Query parameter, if any
 *
 * @param string $name
 * @return string|null
 */
function getQueryParameter(string $name): ?string
{
    if (array_key_exists($name, $_GET)) {
        return $_GET[$name];
    }

    return null;
}

/**
 * @param string $email
 * @return void
 */
function writeLogLogin(string $email)
{
    writeLog("LOGIN", [$email]);
}

/**
 * @param string $email
 * @return void
 */
function writeLogLogout(string $email)
{
    writeLog('LOGOUT', [$email]);
}

/**
 * @param string $email
 * @return void
 */
function writeLogRegistration(string $email)
{
    writeLog('REGISTRATION', [$email]);
}

/**
 * @param string $event
 * @param array $tags
 * @return void
 */
function writeLog(string $event, array $tags = [])
{
    $logsFilename = 'logs.txt';

    createFileIfNotExists($logsFilename);

    // costruisco il messaggio da scrivere
    $row = formatLogMessage($event, $tags);

    // scrivo il messaggio di log
    file_put_contents(
        buildPathRelativeToDocumentRootParent($logsFilename),
        $row,
        FILE_APPEND | LOCK_EX
    );
}

/**
 * @param string $filename path relativo alla cartella padre di document root
 * @return void
 */
function createFileIfNotExists(string $filename)
{
    $path = buildPathRelativeToDocumentRootParent($filename);

    // creo il file se non esiste
    if (!file_exists($path)) {
        file_put_contents($path, '');
    }
}

/**
 *
 *
 * @param string $filename
 * @return string
 */
function buildPathRelativeToDocumentRootParent(string $filename): string
{
    $documentRoot = $_SERVER['DOCUMENT_ROOT'];
    $path = $documentRoot . '/../' . $filename;

    return $path;
}

/**
 * @param string $message
 * @param array $tags array piano di stringhe usate come tag
 * @return string
 */
function formatLogMessage(string $message, array $tags = []): string
{
    $message = date('[Y-m-d H:i:s]') . ' ' . $message;

    if (count($tags) > 0) {
        $message .= ' [';
        $message  = $message . implode(', ', $tags);
        $message .= ']';
    }

    return $message . PHP_EOL;
}
