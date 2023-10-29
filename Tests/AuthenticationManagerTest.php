<?php
declare(strict_types=1);

require_once(__DIR__.'/BaseTestCase.php');

/**
 *
 */
final class AuthenticationManagerTest extends BaseTestCase
{
    /**
     * @return void
     */
    public function testAddUser(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());

        $this->assertFalse($authenticationManager->isUserAuthenticated());

        // do login
        $user = new User('bar@example.com', 'bar');
        $authenticationManager->addUser($user);
        $authenticationManager->emailExists('bar@example.com');
    }

    /**
     * @return void
     */
    public function testAuthenticateUser(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());

        $this->assertFalse($authenticationManager->isUserAuthenticated());

        // do login
        $user = new User('bar@example.com', 'bar');
        $authenticationManager->addUser($user);
        $authenticationManager->authenticateUser($user);

        $this->assertTrue($authenticationManager->isUserAuthenticated());
        $this->assertEquals('bar@example.com', $authenticationManager->getEmailOfAuthenticatedUser());
    }

    /**
     * @return void
     */
    public function testCheckCredentials(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());

        $user = User::buildWithPlainPassword('foo@example.com', 'foo');
        $this->assertFalse($authenticationManager->checkCredentials($user));

        $user = User::buildWithPlainPassword('bar@example.com', 'bar');
        $this->assertTrue($authenticationManager->checkCredentials($user));
    }

    /**
     * @return void
     */
    public function testEmailExists(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());

        $this->assertFalse($authenticationManager->emailExists('foo@example.com'));
        $this->assertTrue($authenticationManager->emailExists('bar@example.com'));
    }

    /**
     * @return void
     */
    public function testGetEmailOfAuthenticatedUser(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());

        $this->assertNull($authenticationManager->getEmailOfAuthenticatedUser());

        $user = new User('bar@example.com', 'bar');
        $authenticationManager->authenticateUser($user);
        $this->assertEquals('bar@example.com', $authenticationManager->getEmailOfAuthenticatedUser());
    }

    /**
     * @return void
     */
    public function testGetUsers(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());

        $users = $authenticationManager->getUsers();

        $this->assertIsArray($users);
        $this->assertCount(1, $users);
        $this->assertContainsOnlyInstancesOf(
            User::class,
            $users,
        );
    }

    /**
     * @return void
     */
    public function testIsUserAuthenticated(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());
        $this->assertFalse($authenticationManager->isUserAuthenticated());

        // do login
        $user = new User('bar@example.com', 'bar');
        $authenticationManager->authenticateUser($user);

        $this->assertTrue($authenticationManager->isUserAuthenticated());
        $this->assertEquals('bar@example.com', $authenticationManager->getEmailOfAuthenticatedUser());
    }
}
