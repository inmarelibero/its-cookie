<?php

class Logger
{
    /**
     * 
     */
    public function writeLogVisitedPage()
    {
        // sapere data/ora
        $date = date('Y-m-d H:i:s');

        // sapere path della pagina
        $path = $_SERVER['REQUEST_URI'];

        // costruisco la stringa log da scrivere nel file logs.txt
        $logMessage = '[' . $date . '] pagina visitata ' . $path;

        $this->appendToLogs($logMessage);
    }

    /**
     * 
     */
    private function appendToLogs(string $logMessage)
    {
        // aggiungere il log al file logs.txt (creare il file se non esiste)
        file_put_contents(__DIR__.'/logs.txt', $logMessage.PHP_EOL , FILE_APPEND | LOCK_EX);
    }
}
