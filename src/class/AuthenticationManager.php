<?php

class AuthenticationManager
{
    private $fileManager;

    /**
     *
     */
    public function __construct(App $app)
    {
        $this->fileManager = new FileManager($app);
    }

    /**
     * @param $email
     * @param $password
     * @return void
     */
    public function addUser($email, $password)
    {
        $users = $this->getUsers();

        $users[] = [
            'email' => $email,
            'password' => $password,
        ];

        $this->saveUsers($users);
    }

    /**
     * @param $email
     * @return void
     */
    public function authenticateUser($email)
    {
        $_SESSION['email'] = $email;
    }

    /**
     * @param $email
     * @param $password
     * @return bool
     */
    public function checkCredentials($email, $password): bool
    {
        $users = $this->getUsers();

        foreach ($users as $user) {
            if ($email === $user['email'] && $password === $user['password']) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $email
     * @param array $users
     * @return bool
     */
    public function emailExists($email, array $users): bool
    {
        foreach ($users as $user) {
            if ($user['email'] === $email) {
                return true;
            }
        }

        return false;
    }

    /**
     * @return string|null
     */
    public function getEmailOfAuthenticatedUser(): string | null
    {
        if ($this->isUserAuthenticated()) {
            return $_SESSION['email'];
        }

        return null;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        $this->fileManager->createFileIfNotExists('users.json');

        $usersFilename = $this->fileManager->buildPathRelativeToProjectRoot('users.json');
        $content = file_get_contents($usersFilename);

        $users = json_decode($content, true);

        if ($users === null) {
            return [];
        }

        return $users;
    }

    /**
     * @return bool
     */
    public function isUserAuthenticated()
    {
        return array_key_exists('email', $_SESSION);
    }

    /**
     * @param array $users
     * @return void
     */
    private function saveUsers(array $users)
    {
        $usersFilename = $this->fileManager->buildPathRelativeToProjectRoot('users.json');

        file_put_contents($usersFilename, json_encode($users));
    }
}