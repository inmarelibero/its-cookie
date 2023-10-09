<?php


class FileManager
{
    /**
     * @param string $filename path relativo alla cartella padre di document root
     * @return void
     */
    public function createFileIfNotExists(string $filename)
    {
        $path = $this->buildPathRelativeToDocumentRootParent($filename);

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
    public function buildPathRelativeToDocumentRootParent(string $filename): string
    {
        $documentRoot = $_SERVER['DOCUMENT_ROOT'];

        $path = $documentRoot . '/../' . $filename;

        return $path;
    }
}