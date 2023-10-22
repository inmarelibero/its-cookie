<?php

use PHPUnit\Framework\TestCase;

/**
 *
 */
class BaseTestCase extends TestCase
{
    private $app;
    private $fileManager;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        $this->app = new App('test');
        $this->fileManager = new FileManager($this->app);

        $this->resetFixtures();
    }

    /**
     * @return void
     */
    protected function tearDown(): void
    {
        $this->resetFixtures();
    }

    /**
     * @return App
     */
    protected function getApp(): App
    {
        return $this->app;
    }

    /**
     * @return void
     */
    private function resetFixtures()
    {
        /**
         * reset users.json
         */
        if (!(file_exists($this->fileManager->getProjectRoot()) && is_dir($this->fileManager->getProjectRoot()))) {
            mkdir($this->fileManager->getProjectRoot());
        }

        file_put_contents($this->fileManager->buildPathRelativeToProjectRoot('users.json'), json_encode([
            [
                'email' => 'bar@example.com',
                'password' => 'bar',
            ]
        ]));

        /**
         * reset logs.txt
         */
        if (file_exists($this->fileManager->buildPathRelativeToProjectRoot(Logger::getLogFilename()))) {
            unlink($this->fileManager->buildPathRelativeToProjectRoot(Logger::getLogFilename()));
        }
    }
}