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
     * @param string $environment
     * @return void
     */
    private function setEnvironment(string $environment): void
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

    /**
     * @return string
     */
    public function getDatabaseHost(): string
    {
        return $this->readConfigValueForKey('APP_DATABASE_HOST');
    }

    /**
     * @return string
     */
    public function getDatabasePort(): string
    {
        return $this->readConfigValueForKey('APP_DATABASE_PORT');
    }

    /**
     * @return string
     */
    public function getDatabaseName(): string
    {
        return $this->readConfigValueForKey('APP_DATABASE_NAME');
    }

    /**
     * @return string
     */
    public function getDatabaseUsername(): string
    {
        return $this->readConfigValueForKey('APP_DATABASE_USER');
    }

    /**
     * @return string
     */
    public function getDatabasePassword(): string
    {
        return $this->readConfigValueForKey('APP_DATABASE_PWD');
    }

    /**
     * @param string $configKey
     * @return string
     */
    private function readConfigValueForKey(string $configKey): string
    {
        if ($this->isTest()) {
            require_once(__DIR__ . '/../../config.test.php');
        } else {
            require_once(__DIR__ . '/../../config.php');
        }

        $userDefinedConstants = array_filter(get_defined_constants(), function(string $k) {
            return str_starts_with($k, 'APP_');
        }, ARRAY_FILTER_USE_KEY);

        if (!array_key_exists($configKey, $userDefinedConstants)) {
            throw new InvalidArgumentException("Constant {${$configKey}} not defined in config.php or config.test.php");
        }

        return $userDefinedConstants[$configKey];
    }
}
