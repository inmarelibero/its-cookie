<?php

/**
 *
 */
class DatabaseManager
{
    private $app;

    /**
     * @return void
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * @return PDO
     */
    public function createConnection(): PDO
    {
        $host = $this->app->getDatabaseHost();
        $port = $this->app->getDatabasePort();
        $databaseName = $this->app->getDatabaseName();
        $username = $this->app->getDatabaseUsername();
        $password = $this->app->getDatabasePassword();

        try {
            $pdo = new PDO("mysql:host=$host;port=$port;dbname=$databaseName", $username, $password);

            // Set the PDO error mode to exception
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("ERRORE: Impossibile stabilire una connessione al database: {$e->getMessage()}");
        }

        return $pdo;
    }
}
