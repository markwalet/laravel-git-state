<?php

namespace MarkWalet\GitState\Tests;

use MarkWalet\GitState\Drivers\FileGitDriver;
use MarkWalet\GitState\Drivers\GitDriver;
use MarkWalet\GitState\Exceptions\MissingConfigurationException;
use MarkWalet\GitState\GitDriverFactory;
use MarkWalet\GitState\GitStateManager;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class GitStateManagerTest extends TestCase
{
    #[Test]
    public function it_can_initialize_a_driver(): void
    {
        $manager = new GitStateManager(new GitDriverFactory, [
            'drivers' => [
                'file-instance' => [
                    'driver' => 'file',
                    'path' => __DIR__.'/test-data/on-master',
                ],
            ],
        ]);

        $driver = $manager->driver('file-instance');

        $this->assertInstanceOf(FileGitDriver::class, $driver);
    }

    #[Test]
    public function it_uses_the_default_driver_if_no_driver_is_specified(): void
    {
        $driver = $this->createMock(GitDriver::class);

        $factory = $this->createMock(GitDriverFactory::class);
        $factory->expects($this->once())
            ->method('make')
            ->with(['driver' => 'mock'])
            ->willReturn($driver);

        $manager = new GitStateManager($factory, [
            'default' => 'test-instance',
            'drivers' => [
                'test-instance' => [
                    'driver' => 'mock',
                ],
            ],
        ]);

        $resolvedDriver = $manager->driver();

        $this->assertSame($driver, $resolvedDriver);
    }

    #[Test]
    public function it_throws_an_exception_when_no_drivers_are_specified(): void
    {
        $manager = new GitStateManager(new GitDriverFactory, [
            'drivers' => null,
        ]);

        $this->expectException(MissingConfigurationException::class);

        $manager->driver('test');
    }

    #[Test]
    public function it_throws_an_exception_when_the_configuration_for_the_given_driver_is_not_found(): void
    {
        $manager = new GitStateManager(new GitDriverFactory, [
            'default' => 'fake-instance',
            'drivers' => [],
        ]);
        $this->expectException(MissingConfigurationException::class);

        $manager->driver('non-existing');
    }

    #[Test]
    public function it_keeps_track_of_all_active_drivers(): void
    {
        $firstDriver = $this->createMock(GitDriver::class);
        $secondDriver = $this->createMock(GitDriver::class);

        $factory = $this->createMock(GitDriverFactory::class);
        $factory->expects($this->exactly(2))
            ->method('make')
            ->willReturnOnConsecutiveCalls($firstDriver, $secondDriver);

        $manager = new GitStateManager($factory, [
            'default' => 'first-instance',
            'drivers' => [
                'first-instance' => [
                    'driver' => 'mock',
                ],
                'other-instance' => [
                    'driver' => 'mock',
                ],
            ],
        ]);

        $before = $manager->getActiveDrivers();

        $manager->driver('first-instance');
        $manager->driver('other-instance');

        $after = $manager->getActiveDrivers();

        $this->assertCount(0, $before);
        $this->assertCount(2, $after);
    }

    #[Test]
    public function initializes_the_same_driver_only_once(): void
    {
        $factory = $this->createMock(GitDriverFactory::class);
        $factory->expects($this->exactly(2))->method('make');
        $manager = new GitStateManager($factory, [
            'default' => 'mock',
            'drivers' => [
                'mock' => [],
                'test' => [],
            ],
        ]);

        $manager->driver('mock');
        $manager->driver('mock');
        $manager->driver('mock');
        $manager->driver('test');
        $manager->driver('test');

        $this->assertCount(2, $manager->getActiveDrivers());
    }
}
