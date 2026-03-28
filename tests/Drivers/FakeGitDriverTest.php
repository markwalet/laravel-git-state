<?php

namespace MarkWalet\GitState\Tests\Drivers;

use Carbon\Carbon;
use MarkWalet\GitState\Drivers\FakeGitDriver;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class FakeGitDriverTest extends TestCase
{
    #[Test]
    public function it_can_set_the_current_branch_from_configuration(): void
    {
        $git = new FakeGitDriver(['branch' => 'feature-12']);

        $branch = $git->currentBranch();

        $this->assertEquals('feature-12', $branch);
    }

    #[Test]
    public function the_current_branch_defaults_to_master(): void
    {
        $git = new FakeGitDriver;

        $branch = $git->currentBranch();

        $this->assertEquals('master', $branch);
    }

    #[Test]
    public function it_can_update_the_current_branch(): void
    {
        $git = new FakeGitDriver;
        $git->updateCurrentBranch('new-feature');

        $branch = $git->currentBranch();

        $this->assertEquals('new-feature', $branch);
    }

    #[Test]
    public function it_can_set_the_latest_commit_metadata_from_configuration(): void
    {
        $git = new FakeGitDriver([
            'hash' => '3859cf1331b88a361140eff8ff8a2a926eab12f9',
            'timestamp' => 1594823686,
            'title' => 'Latest test commit',
            'description' => "This is the commit description.\n\nIt spans multiple lines.",
        ]);

        $this->assertEquals('3859cf1', $git->latestCommitHash(true));
        $this->assertEquals('2020-07-15T14:34:46+00:00', $git->latestCommitTimestamp()->toIso8601String());
        $this->assertEquals('Latest test commit', $git->latestCommitTitle());
        $this->assertEquals("This is the commit description.\n\nIt spans multiple lines.", $git->latestCommitDescription());
    }

    #[Test]
    public function it_can_update_the_latest_commit_metadata(): void
    {
        $git = new FakeGitDriver;
        $git->updateLatestCommit('3859cf1331b88a361140eff8ff8a2a926eab12f9');
        $git->updateLatestCommitTimestamp(1594823686);
        $git->updateLatestCommitTitle('Latest test commit');
        $git->updateLatestCommitDescription("This is the commit description.\n\nIt spans multiple lines.");

        $this->assertEquals('3859cf1331b88a361140eff8ff8a2a926eab12f9', $git->latestCommitHash());
        $this->assertInstanceOf(Carbon::class, $git->latestCommitTimestamp());
        $this->assertEquals('2020-07-15T14:34:46+00:00', $git->latestCommitTimestamp()->toIso8601String());
        $this->assertEquals('Latest test commit', $git->latestCommitTitle());
        $this->assertEquals("This is the commit description.\n\nIt spans multiple lines.", $git->latestCommitDescription());
    }
}
