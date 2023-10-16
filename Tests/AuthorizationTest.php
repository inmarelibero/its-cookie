<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class AuthorizationTest extends TestCase
{
    /**
     * @return void
     */
    public function testAuthenticateUser(): void
    {
        $this->assertFalse(isUserAuthenticated());

        // do login
        authenticateUser('b@example.com');

        $this->assertTrue(isUserAuthenticated());
    }

    /**
     * @return void
     */
    public function testHandleLoginForm(): void
    {
        // do login
        $this->assertTrue(
            handleLoginForm('a@example.com', 'bar')
        );
    }
}
