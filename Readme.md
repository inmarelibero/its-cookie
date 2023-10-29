# Demo project

## Setup project

1. create a database (eg. `demo_db`)
2. setup configuration in `config.php`, for example:

        <?php
    
        const APP_DATABASE_HOST = '127.0.0.1';
        const APP_DATABASE_PORT = '3306';
        const APP_DATABASE_USER = 'root';
        const APP_DATABASE_PWD = 'root';
        const APP_DATABASE_NAME = 'demo_db';

3. create table `user` with the following syntax:

        CREATE TABLE `user` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `email` varchar(255) NOT NULL,
            `password` varchar(255) NOT NULL,
            `enabled` tinyint(1) NOT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `email_unique` (`email`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

4. create table `log` with the following syntax:

        CREATE TABLE `log` (
            `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
            `date` datetime NOT NULL,
            `event` varchar(255) NOT NULL DEFAULT '',
            `tags` longtext NOT NULL,
            PRIMARY KEY (`id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

## Run tests

1. create a database (eg. `demo_db_test`)
2. setup configuration in `config.test.php`, for example:

        <?php
    
        const APP_DATABASE_HOST = '127.0.0.1';
        const APP_DATABASE_PORT = '3306';
        const APP_DATABASE_USER = 'root';
        const APP_DATABASE_PWD = 'root';
        const APP_DATABASE_NAME = 'demo_db_test';
3. run `./phpunit --bootstrap init.php Tests`
