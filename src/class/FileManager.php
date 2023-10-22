<?php

/**
 *
 */
class FileManager
{
    private $app;

    /**
     *
     */
    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $filename path relativo alla project root
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
        $projectRoot = $this->getProjectRoot();

        $path = $projectRoot . '/' . $filename;

        return $path;
    }

    /**
     * @return string
     */
    public function getProjectRoot(): string
    {
        if ($this->app->isTest()) {
            return __DIR__.'/../../Tests/cache';
        }

        return __DIR__.'/../..';
    }
}