<?php

namespace MarkWalet\GitState\Tests;

use MarkWalet\GitState\Drivers\FakeGitDriver;
use MarkWalet\GitState\Drivers\GitDriver;
use MarkWalet\GitState\Facades\GitState;
use MarkWalet\GitState\GitStateManager;

class GitStateServiceProviderTest extends LaravelTestCase
{
    /** @test */
    public function it_binds_a_git_manager_to_the_application()
    {
        $bindings = $this->app->getBindings();

        $this->assertArrayHasKey(GitStateManager::class, $bindings);
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

    /** @test */
    public function it_registers_a_facade()
    {
        $this->app['config']['git-state.default'] = 'test';
        $this->app['config']['git-state.drivers.test'] = ['driver' => 'fake'];
        $branch = GitState::currentBranch();

        $this->assertEquals('master', $branch);
    }
}
