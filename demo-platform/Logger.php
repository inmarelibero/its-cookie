<?php

class Logger
{
    /**
     * 
     */
    public function writeLogVisitedPage()
    {
        $this->appendToLogs('Pagina visitata ' . $_SERVER['REQUEST_URI']);
    }

    /**
     *
     */
    public function writeLogUserLogin(string $email)
    {

        $this->appendToLogs('Utente ' . $email . ' ha fatto login');
    }

    /**
     *
     */
    private function appendToLogs(string $logMessage)
    {
        // sapere data/ora
        $date = date('Y-m-d H:i:s');

        $fullMessage = '[' . $date .'] ' . $logMessage;

        // aggiungere il log al file logs.txt (creare il file se non esiste)
        file_put_contents(__DIR__.'/logs.txt', $fullMessage.PHP_EOL , FILE_APPEND | LOCK_EX);
    }
}
