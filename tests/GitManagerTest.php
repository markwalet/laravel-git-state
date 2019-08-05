<?php

namespace MarkWalet\GitState\Tests;

use MarkWalet\GitState\Drivers\FakeGitDriver;
use MarkWalet\GitState\Drivers\FileGitDriver;
use MarkWalet\GitState\Drivers\GitDriver;
use MarkWalet\GitState\Exceptions\MissingConfigurationException;
use MarkWalet\GitState\GitDriverFactory;
use MarkWalet\GitState\GitManager;

class GitManagerTest extends LaravelTestCase
{
    /** @test */
    public function it_can_initialize_a_driver()
    {
        $this->app['config']['git-state.drivers.file-instance'] = [
            'driver' => 'file',
            'path' => __DIR__ . '/test-data/on-master',
        ];
        /** @var GitManager $manager */
        $manager = $this->app->make(GitManager::class);

        $driver = $manager->driver('file-instance');

        $this->assertInstanceOf(FileGitDriver::class, $driver);
    }

    /** @test */
    public function it_uses_the_default_driver_if_no_drier_is_specified()
    {
        $this->app['config']['git-state.default'] = 'fake-instance';
        $this->app['config']['git-state.drivers.fake-instance'] = [
            'driver' => 'fake',
        ];
        /** @var GitManager $manager */
        $manager = $this->app->make(GitManager::class);

        $driver = $manager->driver();

        $this->assertInstanceOf(FakeGitDriver::class, $driver);
    }

    /** @test */
    public function it_throws_an_exception_when_no_drivers_are_specified()
    {
        $this->app['config']['git-state.drivers'] = null;
        /** @var GitManager $manager */
        $manager = $this->app->make(GitManager::class);

        $this->expectException(MissingConfigurationException::class);

        $manager->driver('fake');
    }

    /** @test */
    public function it_throws_an_exception_when_the_configuration_for_the_given_driver_is_not_found()
    {
        $this->app['config']['git-state.drivers'] = [];
        /** @var GitManager $manager */
        $manager = $this->app->make(GitManager::class);

        $this->expectException(MissingConfigurationException::class);

        $manager->driver('non-existing');
    }

    /** @test */
    public function it_keeps_track_of_all_active_drivers()
    {
        $this->app['config']['git-state.drivers.fake-instance'] = [
            'driver' => 'fake',
        ];
        $this->app['config']['git-state.drivers.other-instance'] = [
            'driver' => 'exec',
            'path' => __DIR__ . '/test-data/on-nested-feature',
        ];

        /** @var GitManager $manager */
        $manager = $this->app->make(GitManager::class);

        $before = $manager->getActiveDrivers();

        $manager->driver('fake-instance');
        $manager->driver('other-instance');

        $after = $manager->getActiveDrivers();

        $this->assertCount(0, $before);
        $this->assertCount(2, $after);
    }

    /** @test */
    public function it_passes_methods_through_to_the_default_driver()
    {
        $this->app['config']['git-state.default'] = 'mock';
        $this->app['config']['git-state.drivers.mock'] = [];
        $driver = $this->createMock(GitDriver::class);
        $driver->expects($this->exactly(1))->method('currentBranch')->willReturn('feature/branch-2');
        $factory = $this->createMock(GitDriverFactory::class);
        $factory->method('make')->willReturn($driver);
        $this->app->bind(GitDriverFactory::class, function () use ($factory) {
            return $factory;
        });
        /** @var GitManager $manager */
        $manager = $this->app->make(GitManager::class);

        $branch = $manager->currentBranch();

        $this->assertEquals('feature/branch-2', $branch);
    }

    /** @test */
    public function initializes_the_same_driver_only_once()
    {
        $this->app['config']['git-state.default'] = 'mock';
        $this->app['config']['git-state.drivers.mock'] = [];
        $this->app['config']['git-state.drivers.test'] = [];
        $factory = $this->createMock(GitDriverFactory::class);
        $this->app->bind(GitDriverFactory::class, function () use ($factory) {
            return $factory;
        });
        $factory->expects($this->exactly(2))->method('make');
        /** @var GitManager $manager */
        $manager = $this->app->make(GitManager::class);

        $manager->driver('mock');
        $manager->driver('mock');
        $manager->driver('mock');
        $manager->driver('test');
        $manager->driver('test');

        $this->assertCount(2, $manager->getActiveDrivers());
    }
}
