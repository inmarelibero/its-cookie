<?php

class RedirectManager
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
     * @param $path
     * @return void
     */
    public function redirect($path = null): void
    {
        if ($path === null) {
            $path = 'homepage.php';
        }

        header("Location: $path");
        exit;
    }


    /**
     * @return void
     */
    public function redirectIfNotAuthenticated($path = null)
    {
        if (!$this->authenticationManager->isUserAuthenticated()) {
            $this->redirect($path);
        }
    }
}