<?php

namespace MarkWalet\GitState\Tests\Drivers;

use MarkWalet\GitState\Drivers\FileGitDriver;
use MarkWalet\GitState\Exceptions\FileNotFoundException;
use MarkWalet\GitState\Exceptions\InvalidArgumentException;
use MarkWalet\GitState\Exceptions\NoGitRepositoryException;
use PHPUnit\Framework\TestCase;

class FileGitDriverTest extends TestCase
{
    /** @test */
    public function it_can_get_the_latest_branch_of_a_git_repository()
    {
        $git = new FileGitDriver(['path' => __DIR__.'/../test-data/on-master']);

        $branch = $git->currentBranch();

        $this->assertEquals('master', $branch);
    }

    /** @test */
    public function it_does_not_escape_forward_slashes_in_the_branch_name()
    {
        $git = new FileGitDriver(['path' => __DIR__.'/../test-data/on-nested-feature']);

        $branch = $git->currentBranch();

        $this->assertEquals('feature/issue-12', $branch);
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

    /** @test */
    public function it_throws_an_exception_when_the_head_file_is_not_found()
    {
        $git = new FileGitDriver(['path' => __DIR__.'/../test-data/no-head']);

        $this->expectException(FileNotFoundException::class);

        $git->currentBranch();
    }
}
