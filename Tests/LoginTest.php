<?php
declare(strict_types=1);

require_once(__DIR__.'/BaseTestCase.php');

/**
 *
 */
final class LoginTest extends BaseTestCase
{
    /**
     * @return void
     */
    public function testHandleLoginForm(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());
        $loginHandler = new LoginHandler($authenticationManager);

        $user = $loginHandler->handleLoginForm('bar@example.com', 'bar');

        //
        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('bar@example.com', $user->getEmail());
        $this->assertEquals(PasswordHasher::hashPassword('bar'), $user->getHashedPassword());
    }
}
