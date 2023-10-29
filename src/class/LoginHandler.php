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
     * @param string $email
     * @param string $plainPassword
     * @return User
     * @throws Exception
     */
    public function handleLoginForm(string $email, string $plainPassword): User
    {
        if (empty($email)) {
            throw new Exception('Campo email obbligatorio');
        }

        if (empty($plainPassword)) {
            throw new Exception('Campo password obbligatorio');
        }

        if (strlen($plainPassword) < 3) {
            throw new Exception('Password troppo corta');
        }

        $user = $this->authenticationManager->findUserByEmail($email);

        // @TODO: prevent login if user is not enabled

        if ($this->authenticationManager->checkCredentials($user, $email, $plainPassword)) {
            return $user;
        }

        throw new Exception('Utente e password non trovati');
    }
}