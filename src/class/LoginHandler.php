<?php

class LoginHandler
{
    protected $authenticationManager;

    /**
     *
     */
    public function __construct(AuthenticationManager $authenticationManager)
    {
        $this->authenticationManager = $authenticationManager;
    }

    /**
     * @param $email
     * @param $password
     * @return true|array true if user can be authenticated, an array of strings representing errors if not
     */
    public function handleLoginForm($email, $password)
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
            if ($this->authenticationManager->checkCredentials($email, $password)) {
                return true;
            } else {
                $errors[] = 'Utente e password non trovati';
            }
        }

        return $errors;
    }
}