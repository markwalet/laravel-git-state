<?php

namespace MarkWalet\GitState;

use MarkWalet\GitState\Drivers\GitDriver;
use MarkWalet\GitState\Exceptions\MissingConfigurationException;

use Illuminate\Contracts\Foundation\Application;

class GitManager
{
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * The git driver factory instance.
     *
     * @var GitDriverFactory
     */
    private $factory;

    /**
     * The active git driver instances.
     * This is used for caching.
     *
     * @var array
     */
    protected $drivers = [];

    /**
     * GitManager constructor.
     *
     * @param Application $app
     * @param GitDriverFactory $factory
     */
    public function __construct(Application $app, GitDriverFactory $factory)
    {
        $this->app = $app;
        $this->factory = $factory;
    }

    /**
     * Get a git driver instance.
     *
     * @param string|null $name
     * @return GitDriver
     */
    public function driver(string $name = null): GitDriver
    {
        // Set the name to default when null.
        $name = $name ?: $this->getDefaultDriver();

        // Get configuration.
        $config = $this->configuration($name);

        // Return the driver when it is already initialized.
        if (array_key_exists($name, $this->drivers)) {
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
        return $this->app['config']['git-state.default'];
    }

    /**
     * Get a list of all drivers that are initialized.
     *
     * @return array
     */
    public function getActiveDrivers(): array
    {
        return $this->drivers;
    }

    /**
     * Get the configuration for a driver.
     *
     * @param string $name
     * @return array
     * @throws MissingConfigurationException
     */
    protected function configuration(string $name)
    {
        // Get a list of drivers.
        $drivers = $this->app['config']['git-state.drivers'];

        if (is_null($drivers)) {
            throw new MissingConfigurationException('git-state.drivers');
        }

        // Throw exception when configuration is not found.
        if (array_key_exists($name, $drivers) === false) {
            throw new MissingConfigurationException($name);
        }

        // Return driver configuration.
        return $drivers[$name];
    }

    /**
     * Dynamically pass methods to the default codec.
     *
     * @param string $method
     * @param array $parameters
     * @return mixed
     * @throws Exceptions\MissingDriverException
     */
    public function __call($method, $parameters)
    {
        return $this->driver()->$method(...$parameters);
    }
}
