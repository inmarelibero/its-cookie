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
        $logger = new Logger($this->getApp());

        // assert file does not exist
        $this->assertFalse(file_exists(__DIR__.'/cache/logs.txt'));

        // write log
        $logger->writeLogLogin('bar@exmaple.com');

        // verify log
        $this->assertStringContainsString('LOGIN', file_get_contents(__DIR__.'/cache/logs.txt'));

        $this->assertFileExists(__DIR__.'/cache/logs.txt');
    }

    /**
     * @return void
     */
    public function testWriteLogLogout(): void
    {
        $logger = new Logger($this->getApp());

        // assert file does not exist
        $this->assertFalse(file_exists(__DIR__.'/cache/logs.txt'));

        // write log
        $logger->writeLogLogout('bar@exmaple.com');

        // verify log
        $this->assertStringContainsString('LOGOUT', file_get_contents(__DIR__.'/cache/logs.txt'));

        $this->assertFileExists(__DIR__.'/cache/logs.txt');
    }

    /**
     * @return void
     */
    public function testWriteLogRegistration(): void
    {
        $logger = new Logger($this->getApp());

        // assert file does not exist
        $this->assertFalse(file_exists(__DIR__.'/cache/logs.txt'));

        // write log
        $logger->writeLogRegistration('bar@exmaple.com');

        // verify log
        $this->assertStringContainsString('REGISTRATION', file_get_contents(__DIR__.'/cache/logs.txt'));

        $this->assertFileExists(__DIR__.'/cache/logs.txt');
    }
}
