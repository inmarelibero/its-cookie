<?php
class User
{
    private string $email; 
    private string $hashedPassword;

    /**
     * @param string $email
     * @param string $hashedPassword
     */
    function __construct(string $email, string $hashedPassword) {
        $this->email = $email;
        $this->hashedPassword = $hashedPassword;
    }

    /**
     * @param string $email
     * @param string $plainPassword
     * @return User
     */
    static function buildWithPlainPassword(string $email, string $plainPassword): User
    {
        return new User($email, PasswordHasher::hashPassword($plainPassword));
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
}