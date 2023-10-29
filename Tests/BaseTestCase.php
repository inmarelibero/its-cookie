<?php

use PHPUnit\Framework\TestCase;

/**
 *
 */
class BaseTestCase extends TestCase
{
    private App $app;

    /**
     * @return void
     */
    protected function setUp(): void
    {
        session_start();
        session_destroy();

        $this->app = new App('test');

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
         * reset database
         */
        $authenticationManager = new AuthenticationManager($this->app);
        $databaseManager = new DatabaseManager($this->app);
        $connection = $databaseManager->createConnection();

        /**
         * handle table "user"
         */
        $connection->exec(<<<EOF
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
EOF
);
        $connection->exec(sprintf("TRUNCATE TABLE user"));

        /**
         * handle table "log"
         */
        $connection->exec(<<<EOF
CREATE TABLE IF NOT EXISTS `log` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `date` datetime NOT NULL,
  `event` varchar(255) NOT NULL DEFAULT '',
  `tags` longtext NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
EOF
);
        $connection->exec(sprintf("TRUNCATE TABLE log"));



        /**
         * add users
         */
        $authenticationManager->addUser(
            User::buildWithPlainPassword('bar@example.com', 'bar')
        );
    }
}