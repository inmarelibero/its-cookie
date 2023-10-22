<?php

/**
 *
 */
class App
{
    private $environment;

    /**
     * @param string $environment
     */
    public function __construct(string $environment)
    {
        $this->setEnvironment($environment);
    }

    /**
     * @param mixed $environment
     */
    private function setEnvironment($environment): void
    {
        if (!in_array($environment, ['prod', 'test'])) {
            throw new InvalidArgumentException();
        }

        $this->environment = $environment;
    }

    /**
     * @return bool
     */
    public function isTest(): bool{
        return $this->environment === 'test';
    }
}
