<?php

namespace MarkWalet\GitState;

use Illuminate\Support\Arr;
use MarkWalet\GitState\Drivers\GitDriver;
use MarkWalet\GitState\Exceptions\MissingConfigurationException;

/**
 * @method string currentBranch()
 * @method string latestCommitHash(bool $short = false)
 */
class GitStateManager
{
    /**
     * The git driver factory instance.
     *
     * @var GitDriverFactory
     */
    private GitDriverFactory $factory;

    /**
     * The application instance.
     *
     * @var array|string[]
     */
    protected array $config;

    /**
     * The active git driver instances.
     * This is used for caching.
     *
     * @var array|GitDriver[]
     */
    protected array $drivers = [];

    /**
     * GitManager constructor.
     *
     * @param GitDriverFactory $factory
     * @param array|mixed[] $config
     */
    public function __construct(GitDriverFactory $factory, array $config)
    {
        $this->factory = $factory;
        $this->config = $config;
    }

    /**
     * Get a git driver instance.
     *
     * @param string|null $name
     *
     * @return GitDriver
     */
    public function driver(string|null $name = null): GitDriver
    {
        // Set the name to default when null.
        $name = $name ?: $this->getDefaultDriver();

        // Get configuration.
        $config = $this->configuration($name);

        // Return the driver when it is already initialized.
        if (array_key_exists($name, $this->getActiveDrivers())) {
            return $this->drivers[$name];
        }

        // Make and return new instance of driver.
        return $this->drivers[$name] = $this->factory->make($config);
    }

    /**
     * Get the default driver name.
     *
     * @return string
     */
    public function getDefaultDriver(): string
    {
        return $this->config['default'];
    }

    /**
     * Get a list of all drivers that are already initialized.
     *
     * @return array|GitDriver[]
     */
    public function getActiveDrivers(): array
    {
        return $this->drivers;
    }

    /**
     * Get the configuration for a driver.
     *
     * @param string $name
     *
     * @return array|mixed[]
     * @throws MissingConfigurationException
     */
    protected function configuration(string $name): array
    {
        // Get a list of drivers.
        $drivers = Arr::get($this->config, 'drivers');

        if (is_null($drivers)) {
            throw new MissingConfigurationException('drivers');
        }

        // Throw exception when configuration is not found.
        if (array_key_exists($name, $drivers) === false) {
            throw new MissingConfigurationException("drivers.$name");
        }

        // Return driver configuration.
        return $drivers[$name];
    }

    /**
     * Dynamically pass methods to the default codec.
     *
     * @param string $method
     * @param array|mixed[] $parameters
     *
     * @return mixed
     * @throws Exceptions\MissingDriverException
     */
    public function __call(string $method, array $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }
}
