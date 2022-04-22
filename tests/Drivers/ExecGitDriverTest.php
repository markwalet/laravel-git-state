<?php

namespace MarkWalet\GitState\Tests\Drivers;

use InvalidArgumentException;
use MarkWalet\GitState\Drivers\ExecGitDriver;
use MarkWalet\GitState\Drivers\GitDriver;
use MarkWalet\GitState\Exceptions\NoGitRepositoryException;
use PHPUnit\Framework\TestCase;

class ExecGitDriverTest extends TestCase
{
    use DriverTests;

    /**
     * {@inheritdoc}
     */
    protected function driver(string $folder): GitDriver
    {
        return new ExecGitDriver(['path' => __DIR__.'/../test-data/'.$folder]);
    }

    /** @test */
    public function it_throws_an_exception_when_the_path_configuration_is_not_given()
    {
        $this->expectException(InvalidArgumentException::class);

        new ExecGitDriver([]);
    }

    /** @test */
    public function it_throws_an_exception_while_fetching_the_current_branch_name_when_the_folder_is_not_found()
    {
        $this->expectException(NoGitRepositoryException::class);

        $driver = new ExecGitDriver(['path' => __DIR__.'/../test-data/not-existing']);

        $driver->currentBranch();
    }

    /** @test */
    public function it_throws_an_exception_while_fetching_the_commit_hash_when_the_folder_is_not_found()
    {
        $this->expectException(NoGitRepositoryException::class);

        $driver = new ExecGitDriver(['path' => __DIR__.'/../test-data/not-existing']);

        $driver->latestCommitHash();
    }
}
