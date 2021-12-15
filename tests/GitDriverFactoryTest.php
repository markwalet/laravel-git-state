<?php

namespace MarkWalet\GitState\Tests;

use InvalidArgumentException;
use MarkWalet\GitState\Drivers\ExecGitDriver;
use MarkWalet\GitState\Drivers\FakeGitDriver;
use MarkWalet\GitState\Drivers\FileGitDriver;
use MarkWalet\GitState\Exceptions\MissingDriverException;
use MarkWalet\GitState\GitDriverFactory;
use PHPUnit\Framework\TestCase;

class GitDriverFactoryTest extends TestCase
{
    /** @test */
    public function it_can_create_a_fake_driver()
    {
        $factory = new GitDriverFactory();

        $driver = $factory->make([
            'driver' => 'fake',
        ]);

        $this->assertInstanceOf(FakeGitDriver::class, $driver);
    }

    /** @test */
    public function it_can_create_an_exec_driver()
    {
        $factory = new GitDriverFactory();

        $driver = $factory->make([
            'driver' => 'exec',
            'path' => $this->validPath(),
        ]);

        $this->assertInstanceOf(ExecGitDriver::class, $driver);
    }

    /** @test */
    public function it_can_create_a_file_driver()
    {
        $factory = new GitDriverFactory();

        $driver = $factory->make([
            'driver' => 'file',
            'path' => $this->validPath(),
        ]);

        $this->assertInstanceOf(FileGitDriver::class, $driver);
    }

    /** @test */
    public function it_throws_an_exception_when_the_driver_is_not_defined()
    {
        $factory = new GitDriverFactory();

        $this->expectException(InvalidArgumentException::class);

        $factory->make([]);
    }

    /** @test */
    public function it_throws_an_exception_when_the_driver_does_not_exist()
    {
        $factory = new GitDriverFactory();

        $this->expectException(MissingDriverException::class);

        $factory->make([
            'driver' => 'non-existing',
        ]);
    }

    /**
     * Get the absolute path to a valid git repository.
     *
     * @return string
     */
    private function validPath(): string
    {
        return __DIR__ . '/test-data/on-master';
    }
}
