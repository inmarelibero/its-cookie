<?php

class AuthenticationManager
{
    private DatabaseManager $databaseManager;

    /**
     *
     */
    public function __construct(App $app)
    {
        $this->databaseManager = new DatabaseManager($app);
    }

    /**
     * @param User $user
     * @return void
     */
    public function addUser(User $user): void
    {
        $connection = $this->databaseManager->createConnection();

        $sql = "INSERT INTO user (email, password) VALUES (:email, :password)";
        $queryStatement = $connection->prepare($sql);
        $result = $queryStatement->execute([
            'email' => $user->getEmail(),
            'password' => $user->getHashedPassword(),
        ]);

        if (!$result) {
            die('Errore esecuzione query: ' . implode(',', $connection->errorInfo()));
        }

        $lastInsertId = $connection->lastInsertId();
        $user->setId($lastInsertId);
    }

    /**
     * @param User $user
     * @return void
     */
    public function authenticateUser(User $user): void
    {
        if ($user->getId() === null) {
            $user = $this->findUserByEmail($user->getEmail());
        }

        $_SESSION['authenticated_user_id'] = $user->getId();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function checkCredentials(User $user): bool
    {
        $users = $this->getUsers();

        foreach ($users as $currentUser) {
            if ($user->hasEmail($currentUser->getEmail()) && $user->hasHashedPassword($currentUser->getHashedPassword())) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool
    {
        $connection = $this->databaseManager->createConnection();

        $sql = "SELECT COUNT(*) AS count FROM user WHERE email = :email";
        $queryStatement = $connection->prepare($sql);
        $result = $queryStatement->execute([
            'email' => $email,
        ]);

        if (!$result) {
            die('Errore esecuzione query: ' . implode(',', $connection->errorInfo()));
        }
        $result = $queryStatement->fetch(PDO::FETCH_ASSOC);

        return $result['count'] >= 1;
    }

    /**
     * @param int $id
     * @return User|null
     */
    public function findUser(int $id): User | null
    {
        $connection = $this->databaseManager->createConnection();

        $sql = "SELECT * FROM user WHERE id = :id LIMIT 1";
        $queryStatement = $connection->prepare($sql);
        $result = $queryStatement->execute([
            'id' => $id,
        ]);

        if (!$result) {
            die('Errore esecuzione query: ' . implode(',', $connection->errorInfo()));
        }

        $result = $queryStatement->fetchAll(PDO::FETCH_ASSOC);

        return User::buildFromDatabaseRow($result[0]);
    }

    /**
     * @param string $email
     * @return User|null
     */
    public function findUserByEmail(string $email): User | null
    {
        $connection = $this->databaseManager->createConnection();

        $sql = "SELECT * FROM user WHERE email = :email LIMIT 1";
        $queryStatement = $connection->prepare($sql);
        $result = $queryStatement->execute([
            'email' => $email,
        ]);

        if (!$result) {
            die('Errore esecuzione query: ' . implode(',', $connection->errorInfo()));
        }

        $result = $queryStatement->fetchAll(PDO::FETCH_ASSOC);

        return User::buildFromDatabaseRow($result[0]);
    }

    /**
     * @return User|null
     */
    public function getAuthenticatedUser(): User | null
    {
        if ($this->isUserAuthenticated()) {
            return $this->findUser($_SESSION['authenticated_user_id']);
        }

        return null;
    }

    /**
     * @return User[]
     */
    public function getUsers(): array
    {
        $connection = $this->databaseManager->createConnection();

        $sql = "SELECT * FROM user";
        $queryStatement = $connection->prepare($sql);
        $result = $queryStatement->execute();

        if (!$result) {
            die('Errore esecuzione query: ' . implode(',', $connection->errorInfo()));
        }
        $result = $queryStatement->fetchAll(PDO::FETCH_ASSOC);

        $users = [];
        foreach ($result as $row) {
            $users[] = User::buildFromDatabaseRow($row);
        }

        return $users;
    }

    /**
     * @return bool
     */
    public function isUserAuthenticated(): bool
    {
        return array_key_exists('authenticated_user_id', $_SESSION);
    }
}