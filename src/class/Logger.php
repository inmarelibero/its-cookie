<?php

class Logger
{
    private $databaseManager;

    /**
     *
     */
    public function __construct(App $app)
    {
        $this->databaseManager = new DatabaseManager($app);
    }

    /**
     * @param User $user
     * @return void
     */
    public function writeLogLogin(User $user): void
    {
        $this->writeLog("LOGIN", [$user->getEmail()]);
    }

    /**
     * @param User $user
     * @return void
     */
    public function writeLogLogout(User $user): void
    {
        $this->writeLog('LOGOUT', [$user->getEmail()]);
    }

    /**
     * @param User $user
     * @return void
     */
    public function writeLogRegistration(User $user): void
    {
        $this->writeLog('REGISTRATION', [$user->getEmail()]);
    }

    /**
     * @param string $event
     * @param array $tags
     * @return void
     */
    private function writeLog(string $event, array $tags = [])
    {
        $connection = $this->databaseManager->createConnection();

        $sql = "INSERT INTO log (date, event, tags) VALUES (NOW(), :event, :tags)";
        $queryStatement = $connection->prepare($sql);
        $result = $queryStatement->execute([
            'event' => $event,
            'tags' => implode(', ', $tags),
        ]);

        if (!$result) {
            die('Errore esecuzione query: ' . implode(',', $connection->errorInfo()));
        }
    }

    /**
     * Return the last inserted log, or null if there are no logs
     *
     * @return array|null
     */
    public function getLatestLogAsRow(): array | null
    {
        $connection = $this->databaseManager->createConnection();

        $sql = "SELECT * FROM log ORDER BY date DESC, id DESC LIMIT 1";
        $queryStatement = $connection->prepare($sql);
        $result = $queryStatement->execute();

        if (!$result) {
            die('Errore esecuzione query: ' . implode(',', $connection->errorInfo()));
        }
        $result = $queryStatement->fetch(PDO::FETCH_ASSOC);

        return $result;
    }
}