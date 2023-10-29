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

        // do login
        $this->assertTrue(
            $loginHandler->handleLoginForm('bar@example.com', 'bar') instanceof User
        );
    }
}
