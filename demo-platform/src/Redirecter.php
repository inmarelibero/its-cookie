<?php

/**
 * Classe che espone metodi per effettuare il redirect dell'utente
 */
class Redirecter
{
    /**
     * Redireziona l'utente ad un path specifico
     * @param $path il path a cui redirezionare l'utente
     */
    public function redirectTo($path = '/homepage.php')
    {
        header("Location: ".$path);
        exit();
    }

    /**
     * Redireziona l'utente alla homepage
     */
    public function redirectToHome()
    {
        $this->redirectTo('/homepage.php');
    }

    /**
     * Redireziona l'utente se non è attualmente autenticato
     * @param $path il path a cui redirezionare l'utente
     */
    public function redirectIfNotAuthenticated($path = '/homepage.php')
    {
        if (!isUserAuthenticated()) {
            $this->redirectTo('login.php');
        }
    }

    /**
     * Redireziona l'utente se è attualmente autenticato
     * @param $path il path a cui redirezionare l'utente
     */
    public function redirectIfAuthenticated($path = '/homepage.php')
    {
        if (isUserAuthenticated()) {
            $this->redirectTo($path);
        }
    }
}