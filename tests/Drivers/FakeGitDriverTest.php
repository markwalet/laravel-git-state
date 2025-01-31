<?php

namespace MarkWalet\GitState\Tests\Drivers;

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
}
