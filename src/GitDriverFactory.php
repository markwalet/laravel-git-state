<?php

namespace MarkWalet\GitState;

use MarkWalet\GitState\Drivers\ExecGitDriver;
use MarkWalet\GitState\Drivers\FakeGitDriver;
use MarkWalet\GitState\Drivers\FileGitDriver;
use MarkWalet\GitState\Drivers\GitDriver;
use MarkWalet\GitState\Exceptions\MissingDriverException;

class GitDriverFactory
{
    use RequiresConfigurationKeys;

    /**
     * Create a new codec based on the given configuration.
     *
     * @param array $config
     * @return GitDriver
     */
    public function make(array $config): GitDriver
    {
        $this->require($config, 'driver');

        return $this->createDriver($config['driver'], $config);
    }

    /**
     * Create a new codec instance.
     *
     * @param string $driver
     * @param array $config
     * @return GitDriver
     * @throws MissingDriverException
     */
    protected function createDriver(string $driver, array $config): GitDriver
    {
        switch ($driver) {
            case 'fake':
                return new FakeGitDriver($config);
            case 'exec':
                return new ExecGitDriver($config);
            case 'file':
                return new FileGitDriver($config);
            default:
                throw new MissingDriverException($driver);
        }
    }
}
