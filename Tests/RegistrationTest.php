<?php
declare(strict_types=1);

require_once(__DIR__.'/BaseTestCase.php');

/**
 *
 */
final class RegistrationTest extends BaseTestCase
{
    /**
     * @return void
     */
    public function testHandleRegistrationForm(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());
        $registrationHandler = new RegistrationHandler($authenticationManager);
        $loginHandler = new LoginHandler($authenticationManager);

        // register
        try {
            $registrationHandler->handleRegistrationForm('foo@example.com', 'foo', 'foo');
            $this->assertTrue(true);
        } catch (Exception $exception) {
            $this->fail(sprintf('Registration form handler failed with error "%s"', $exception->getMessage()));
        }

        // do login
        $this->assertTrue(
            $loginHandler->handleLoginForm('foo@example.com', 'foo') instanceof User
        );
    }
}
