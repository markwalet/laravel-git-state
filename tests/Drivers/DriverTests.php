<?php

namespace MarkWalet\GitState\Tests\Drivers;

use MarkWalet\GitState\Drivers\GitDriver;
use MarkWalet\GitState\Exceptions\FileNotFoundException;
use MarkWalet\GitState\Exceptions\RuntimeException;

trait DriverTests
{
    /**
     * Create a driver instance.
     *
     * @param string $folder
     * @return GitDriver
     */
    abstract protected function driver(string $folder): GitDriver;

    /** @test */
    public function it_can_get_the_latest_branch_of_a_git_repository()
    {
        $git = $this->driver('on-master');

        $branch = $git->currentBranch();

        $this->assertEquals('master', $branch);
    }

    /** @test */
    public function it_does_not_escape_forward_slashes_in_the_branch_name()
    {
        $git = $this->driver('on-nested-feature');

        $branch = $git->currentBranch();

        $this->assertEquals('feature/issue-12', $branch);
    }

    /** @test */
    public function it_throws_an_exception_when_the_head_file_is_not_found()
    {
        $git = $this->driver('no-head');

        $this->expectException(RuntimeException::class);

        $git->currentBranch();
    }

    /** @test */
    public function it_can_get_the_latest_short_commit_hash_of_a_git_repository()
    {
        $git = $this->driver('with-commits');

        $commit = $git->latestCommitHash(true);

        $this->assertEquals('202131f', $commit);
    }

    /** @test */
    public function it_can_get_the_latest_long_commit_hash_of_a_git_repository()
    {
        $git = $this->driver('with-commits');

        $commit = $git->latestCommitHash(false);

        $this->assertEquals('202131f0ba24d03d75667ce586be1c1ce3983ce8', $commit);
    }

    /** @test */
    public function it_throws_an_exception_when_the_head_file_is_not_found_for_the_latest_commit()
    {
        $this->expectException(RuntimeException::class);

        $git = $this->driver('broken-head');

        $git->latestCommitHash();
    }
}
