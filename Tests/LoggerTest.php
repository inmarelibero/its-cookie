<?php
declare(strict_types=1);

require_once(__DIR__.'/BaseTestCase.php');

/**
 *
 */
final class LoggerTest extends BaseTestCase
{
    /**
     * @return void
     */
    public function testWriteLogLogin(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());
        $logger = new Logger($this->getApp());

        // write log
        $logger->writeLogLogin($authenticationManager->findUserByEmail('bar@example.com'));

        // verify log
        $latestLog = $logger->getLatestLogAsRow();
        $this->assertEquals('LOGIN', $latestLog['event']);
    }

    /**
     * @return void
     */
    public function testWriteLogLogout(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());
        $logger = new Logger($this->getApp());

        // write log
        $logger->writeLogLogout($authenticationManager->findUserByEmail('bar@example.com'));

        // verify log
        $latestLog = $logger->getLatestLogAsRow();
        $this->assertEquals('LOGOUT', $latestLog['event']);
    }

    /**
     * @return void
     */
    public function testWriteLogRegistration(): void
    {
        $authenticationManager = new AuthenticationManager($this->getApp());
        $logger = new Logger($this->getApp());

        // write log
        $logger->writeLogRegistration($authenticationManager->findUserByEmail('bar@example.com'));

        // verify log
        $latestLog = $logger->getLatestLogAsRow();
        $this->assertEquals('REGISTRATION', $latestLog['event']);
    }
}
