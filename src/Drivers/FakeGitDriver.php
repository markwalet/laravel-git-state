<?php

namespace MarkWalet\GitState\Drivers;

use Illuminate\Support\Arr;

class FakeGitDriver implements GitDriver
{
    /**
     * @var string
     */
    private $branch;

    /**
     * GitDriverInterface constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->branch = Arr::get($config, 'branch', 'master');
    }

    /**
     * Get the current branch.
     *
     * @return string
     */
    public function currentBranch(): string
    {
        return $this->branch;
    }

    /**
     * Update the current branch.
     *
     * @param string $branch
     */
    public function updateCurrentBranch(string $branch): void
    {
        $this->branch = $branch;
    }
}
