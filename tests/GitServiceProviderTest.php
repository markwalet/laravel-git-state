<?php

namespace MarkWalet\GitState\Tests;

use MarkWalet\GitState\Drivers\ExecGitDriver;
use MarkWalet\GitState\Drivers\FakeGitDriver;
use MarkWalet\GitState\Drivers\FileGitDriver;
use MarkWalet\GitState\Drivers\GitDriver;
use MarkWalet\GitState\Exceptions\InvalidArgumentException;
use MarkWalet\GitState\Exceptions\MissingDriverException;
use MarkWalet\GitState\Exceptions\NoGitRepositoryException;
use MarkWalet\GitState\Exceptions\RuntimeException;
use MarkWalet\GitState\GitDriverFactory;
use MarkWalet\GitState\GitManager;
use PHPUnit\Framework\TestCase;

class GitServiceProviderTest extends LaravelTestCase
{
    /** @test */
    public function it_binds_a_git_manager_to_the_application()
    {
        $bindings = $this->app->getBindings();

        $this->assertArrayHasKey(GitManager::class, $bindings);
    }

    /** @test */
    public function it_binds_codec_to_the_application()
    {
        $bindings = $this->app->getBindings();

        $this->assertArrayHasKey(GitDriver::class, $bindings);
    }

    /** @test */
    public function it_codec_resolves_to_default_codec()
    {
        $this->app['config']['git-state.default'] = 'test';
        $this->app['config']['git-state.drivers.test'] = ['driver' => 'fake'];

        $driver = $this->app->make(GitDriver::class);

        $this->assertInstanceOf(FakeGitDriver::class, $driver);
    }
}
