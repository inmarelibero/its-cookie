<?php


class FileManager
{
    /**
     * @param string $filename path relativo alla cartella padre di document root
     * @return void
     */
    public function createFileIfNotExists(string $filename)
    {
        $path = $this->buildPathRelativeToProjectRoot($filename);

        // creo il file se non esiste
        if (!file_exists($path)) {
            file_put_contents($path, '');
        }
    }

    /**
     *
     *
     * @param string $filename
     * @return string
     */
    public function buildPathRelativeToProjectRoot(string $filename): string
    {
        $documentRoot = $this->getDocumentRoot();

        $path = $documentRoot . '/../' . $filename;

        return $path;
    }

    /**
     * @return string
     */
    private function getDocumentRoot(): string
    {
        if ($_SERVER['DOCUMENT_ROOT'] !== '') {
            return $_SERVER['DOCUMENT_ROOT'];
        }

        return __DIR__.'/../../public';
    }
}