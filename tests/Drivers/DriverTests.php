<?php

namespace MarkWalet\GitState\Tests\Drivers;

use MarkWalet\GitState\Drivers\GitDriver;
use MarkWalet\GitState\Exceptions\RuntimeException;
use PHPUnit\Framework\Attributes\Test;

trait DriverTests
{
    /**
     * Create a driver instance.
     *
     * @param string $folder
     * @return GitDriver
     */
    abstract protected function driver(string $folder): GitDriver;

    #[Test]
    public function it_can_get_the_latest_branch_of_a_git_repository(): void
    {
        $git = $this->driver('on-master');

        $branch = $git->currentBranch();

        $this->assertEquals('master', $branch);
    }

    #[Test]
    public function it_does_not_escape_forward_slashes_in_the_branch_name(): void
    {
        $git = $this->driver('on-nested-feature');

        $branch = $git->currentBranch();

        $this->assertEquals('feature/issue-12', $branch);
    }

    #[Test]
    public function it_throws_an_exception_when_the_head_file_is_not_found(): void
    {
        $git = $this->driver('no-head');

        $this->expectException(RuntimeException::class);

        $git->currentBranch();
    }

    #[Test]
    public function it_can_get_the_latest_short_commit_hash_of_a_git_repository(): void
    {
        $git = $this->driver('with-commits');

        $commit = $git->latestCommitHash(true);

        $this->assertEquals('202131f', $commit);
    }

    #[Test]
    public function it_can_get_the_latest_long_commit_hash_of_a_git_repository(): void
    {
        $git = $this->driver('with-commits');

        $commit = $git->latestCommitHash(false);

        $this->assertEquals('202131f0ba24d03d75667ce586be1c1ce3983ce8', $commit);
    }

    #[Test]
    public function it_throws_an_exception_when_the_head_file_is_not_found_for_the_latest_commit(): void
    {
        $this->expectException(RuntimeException::class);

        $git = $this->driver('broken-head');

        $git->latestCommitHash();
    }
}
