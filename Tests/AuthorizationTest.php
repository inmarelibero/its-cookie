<?php
declare(strict_types=1);

require_once(__DIR__.'/BaseTestCase.php');

/**
 *
 */
final class AuthorizationTest extends BaseTestCase
{
    /**
     * @return void
     */
    public function testAuthenticateUser(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());
        $this->assertFalse($authenticationManager->isUserAuthenticated());

        // do login
        $authenticationManager->authenticateUser('bar@example.com');

        $this->assertTrue($authenticationManager->isUserAuthenticated());
        $this->assertEquals('bar@example.com', $authenticationManager->getEmailOfAuthenticatedUser());
    }

    /**
     * @return void
     */
    public function testHandleLoginForm(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());
        $loginHandler = new LoginHandler($authenticationManager);

        // do login
        $this->assertTrue(
            $loginHandler->handleLoginForm('bar@example.com', 'bar')
        );
    }

    /**
     * @return void
     */
    public function testHandleRegistrationForm(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());
        $registrationHandler = new RegistrationHandler($authenticationManager);

        // register
        try {
            $registrationHandler->handleRegistrationForm('foo@example.com', 'foo', 'foo');
            $this->assertTrue(true);
        } catch (Exception $exception) {
            $this->fail(sprintf('Registration form handler failed with error "%s"', $exception->getMessage()));
        }
    }
}
