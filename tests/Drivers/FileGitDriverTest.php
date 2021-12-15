<?php

namespace MarkWalet\GitState\Tests\Drivers;

use InvalidArgumentException;
use MarkWalet\GitState\Drivers\FileGitDriver;
use MarkWalet\GitState\Drivers\GitDriver;
use MarkWalet\GitState\Exceptions\NoGitRepositoryException;
use PHPUnit\Framework\TestCase;

class FileGitDriverTest extends TestCase
{
    use DriverTests;

    /**
     * {@inheritdoc}
     */
    protected function driver(string $folder): GitDriver
    {
        return new FileGitDriver(['path' => __DIR__.'/../test-data/'.$folder]);
    }

    /** @test */
    public function it_throws_an_exception_when_the_path_configuration_is_not_given()
    {
        $this->expectException(InvalidArgumentException::class);

        new FileGitDriver([]);
    }

    /** @test */
    public function it_throws_an_exception_when_the_folder_is_not_found()
    {
        $this->expectException(NoGitRepositoryException::class);

        new FileGitDriver(['path' => __DIR__.'/../test-data/not-existing']);
    }
}
