<?php

namespace MarkWalet\GitState\Tests;

use MarkWalet\GitState\Drivers\FakeGitDriver;
use MarkWalet\GitState\Drivers\GitDriver;
use MarkWalet\GitState\Facades\GitState;
use MarkWalet\GitState\GitDriverFactory;
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
    public function it_binds_a_driver_to_the_application()
    {
        $bindings = $this->app->getBindings();

        $this->assertArrayHasKey(GitDriver::class, $bindings);
    }

    /** @test */
    public function it_binds_the_correct_driver_to_the_application_based_on_the_configuration()
    {
        $this->app['config']['git-state.default'] = 'test';
        $this->app['config']['git-state.drivers.test'] = ['driver' => 'fake'];

        $driver = $this->app->make(GitDriver::class);

        $this->assertInstanceOf(FakeGitDriver::class, $driver);
    }

    /** @test */
    public function it_registers_a_facade()
    {
        /** @var GitStateManager $manager */
        $this->app->bind(GitDriverFactory::class, function () {
            $driver = $this->mock(GitDriver::class);
            $driver->expects('currentBranch')->once()->andReturn('test-branch');
            
            $factory = $this->mock(GitDriverFactory::class);
            $factory->expects('make')->once()->andReturn($driver);
            
            return $factory;
        });
        $branch = GitState::currentBranch();

        $this->assertEquals('test-branch', $branch);
    }
}
