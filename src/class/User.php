<?php
class User
{
    private ?int $id = null;
    private string $email;
    private string $hashedPassword;

    /**
     * @param string $email
     * @param string $hashedPassword
     */
    private function __construct(string $email, string $hashedPassword) {
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * @param string $email
     * @param string $hashedPassword
     * @return User
     */
    static function buildWithHashedPassword(string $email, string $hashedPassword): User
    {
        return new User($email, $hashedPassword);
    }

    /**
     * @param string $email
     * @param string $plainPassword
     * @return User
     */
    static function buildWithPlainPassword(string $email, string $plainPassword): User
    {
        return User::buildWithHashedPassword($email, PasswordHasher::hashPassword($plainPassword));
    }

    /**
     * @param array $row
     * @return User
     */
    static function buildFromDatabaseRow(array $row): User
    {
        $user = User::buildWithHashedPassword($row['email'], $row['password']);

        $user->setId($row['id']);

        return $user;
    }

    /**
     * @return string
     */
    public function getEmail(): string 
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getHashedPassword(): string
    {
        return $this->hashedPassword;
    }

    /**
     * @param string $email
     * @return bool
     */
    public function hasEmail(string $email): bool
    {
        return $this->getEmail() === $email;
    }

    /**
     * @param string $plainPassword
     * @return bool
     */
    public function hasPlainPassword(string $plainPassword): bool
    {
        return $this->getHashedPassword() === PasswordHasher::hashPassword($plainPassword);
    }

    /**
     * @param string $hashedPassword
     * @return bool
     */
    public function hasHashedPassword(string $hashedPassword): bool
    {
        return $this->getHashedPassword() === $hashedPassword;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }
}