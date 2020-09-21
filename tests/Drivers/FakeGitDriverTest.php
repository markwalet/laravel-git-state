<?php

namespace MarkWalet\GitState\Tests\Drivers;

use MarkWalet\GitState\Drivers\FakeGitDriver;
use PHPUnit\Framework\TestCase;

class FakeGitDriverTest extends TestCase
{
    /** @test */
    public function it_can_set_the_current_branch_from_configuration()
    {
        $git = new FakeGitDriver(['branch' => 'feature-12']);

        $branch = $git->currentBranch();

        $this->assertEquals('feature-12', $branch);
    }

    /** @test */
    public function the_current_branch_defaults_to_master()
    {
        $git = new FakeGitDriver;

        $branch = $git->currentBranch();

        $this->assertEquals('master', $branch);
    }

    /** @test */
    public function it_can_update_the_current_branch()
    {
        $git = new FakeGitDriver;
        $git->updateCurrentBranch('new-feature');

        $branch = $git->currentBranch();

        $this->assertEquals('new-feature', $branch);
    }
}
