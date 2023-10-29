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

        //
        $user = User::buildWithPlainPassword('foo@example.com', 'foo');
        $this->assertNull($user->getId());
        $authenticationManager->addUser($user);

        //
        $this->assertEquals(2, $user->getId());
        $authenticationManager->emailExists('bar@example.com');
        $this->assertTrue($user->hasPlainPassword('foo'));
    }

    /**
     * @return void
     */
    public function testAuthenticateUser(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());

        $this->assertFalse($authenticationManager->isUserAuthenticated());

        //
        $user = User::buildWithPlainPassword('foo@example.com', 'foo');
        $this->assertNull($user->getId());
        $authenticationManager->addUser($user);
        $authenticationManager->authenticateUser($user);

        //
        $this->assertTrue($authenticationManager->isUserAuthenticated());
        $this->assertEquals(2, $user->getId());
        $this->assertEquals('foo@example.com', $authenticationManager->getAuthenticatedUser()->getEmail());
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
    public function testFindUser(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());

        $user = $authenticationManager->findUser(1);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('bar@example.com', $user->getEmail());
        $this->assertEquals(PasswordHasher::hashPassword('bar'), $user->getHashedPassword());
        $this->assertEquals(1, $user->getId());
    }

    /**
     * @return void
     */
    public function testFindUserByEmail(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());

        $user = $authenticationManager->findUserByEmail('bar@example.com');

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('bar@example.com', $user->getEmail());
        $this->assertEquals(PasswordHasher::hashPassword('bar'), $user->getHashedPassword());
        $this->assertEquals(1, $user->getId());
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
    public function testGetAuthenticatedUser(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());

        $this->assertNull($authenticationManager->getAuthenticatedUser());

        $user = $authenticationManager->findUserByEmail('bar@example.com');
        $authenticationManager->authenticateUser($user);
        $this->assertInstanceOf(User::class, $authenticationManager->getAuthenticatedUser());
        $this->assertEquals('bar@example.com', $authenticationManager->getAuthenticatedUser()->getEmail());
        $this->assertEquals(1, $authenticationManager->getAuthenticatedUser()->getId());
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
        $this->assertContainsOnlyInstancesOf(User::class, $users);

        foreach ($users as $user) {
            $this->assertNotNull($user->getId());
        }
    }

    /**
     * @return void
     */
    public function testIsUserAuthenticated(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());
        $this->assertFalse($authenticationManager->isUserAuthenticated());

        //
        $user = $authenticationManager->findUserByEmail('bar@example.com');
        $authenticationManager->authenticateUser($user);

        $this->assertTrue($authenticationManager->isUserAuthenticated());
        $this->assertEquals('bar@example.com', $authenticationManager->getAuthenticatedUser()->getEmail());
        $this->assertEquals(1, $authenticationManager->getAuthenticatedUser()->getId());
    }
}
