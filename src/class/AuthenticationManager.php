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

        $sql = "INSERT INTO user (email, password, enabled) VALUES (:email, :password, 1)";
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
     * @param string $newPlainPassword
     * @return void
     * @throws Exception
     */
    public function changePassword(User $user, string $newPlainPassword): void
    {
        // @TODO: implement logic
        if (empty($newPlainPassword)) {
            throw new Exception('Campo password obbligatorio');
        }

        if (strlen($newPlainPassword) < 3) {
            throw new Exception('Password troppo corta');
        }

        $user->setPlainPassword($newPlainPassword);
        $this->persistUser($user);
    }

    /**
     * @param User $user
     * @return void
     */
    public function deleteUser(User $user): void
    {
        // @TODO: implement logic
        $connection = $this->databaseManager->createConnection();

        $sql = "DELETE FROM user WHERE id = :id";
        $queryStatement = $connection->prepare($sql);
        $result = $queryStatement->execute([
            'id' => $user->getId(),
        ]);

        if (!$result) {
            die('Errore esecuzione query: ' . implode(',', $connection->errorInfo()));
        }
    }

    /**
     * @param User $user
     * @param string $email
     * @param string $plainPassword
     * @return bool
     */
    public function checkCredentials(User $user, string $email, string $plainPassword): bool
    {
        return $user->hasEmail($email) && $user->hasPlainPassword($plainPassword);
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

        $result = $queryStatement->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return User::buildFromDatabaseRow($result);
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

        $result = $queryStatement->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        }

        return User::buildFromDatabaseRow($result);
    }

    /**
     * @return User|null
     */
    public function getAuthenticatedUser(): User | null
    {
        if (array_key_exists('authenticated_user_id', $_SESSION)) {
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
        return $this->getAuthenticatedUser() !== null;
    }

    /**
     * @param User $user
     * @return void
     */
    public function persistUser(User $user): void
    {
        $connection = $this->databaseManager->createConnection();

        $sql = "UPDATE user SET email = :email, password = :password, enabled = :enabled WHERE id = :id";
        $queryStatement = $connection->prepare($sql);
        $result = $queryStatement->execute([
            'id' => $user->getId(),
            'email' => $user->getEmail(),
            'enabled' => $user->isEnabled() ? 1 : 0,
            'password' => $user->getHashedPassword(),
        ]);

        if (!$result) {
            die('Errore esecuzione query: ' . implode(',', $connection->errorInfo()));
        }
    }

    /**
     * @param User $user
     * @return void
     */
    public function toggleEnabled(User $user): void
    {
        $user->setIsEnabled(!$user->isEnabled());
        $this->persistUser($user);
    }
}