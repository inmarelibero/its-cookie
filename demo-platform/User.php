<?php

class User
{
    private $email;
    private $encryptedPassword;

    /**
     * 
     */
    public function __construct(string $email, string $encryptedPassword)
    {
        $this->email = $email;
        $this->encryptedPassword = $encryptedPassword;
    }

    /**
     * 
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * 
     */
    public function getEncryptedPassword(): string
    {
        return $this->encryptedPassword;
    }

    /**
     * 
     */
    public function setEncryptedPassword(string $password)
    {
        $this->encryptedPassword = $password;
    }
}
