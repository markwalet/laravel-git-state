<?php

namespace MarkWalet\GitState\Drivers;

use Illuminate\Support\Arr;
use Webmozart\Assert\Assert;

class FakeGitDriver implements GitDriver
{
    /**
     * @var string
     */
    private string $branch;

    /**
     * @var string
     */
    private string $hash;

    /**
     * GitDriverInterface constructor.
     *
     * @param array|string[] $config
     */
    public function __construct(array $config = [])
    {
        $this->branch = (string)Arr::get($config, 'branch', 'master');
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
     * Get the latest commit hash.
     *
     * @param bool $short
     * @return string
     */
    public function latestCommitHash(bool $short = false): string
    {
        return ($short)
            ? mb_substr($this->hash, 0, 7)
            : trim($this->hash);
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

    /**
     * Update the latest commit.
     *
     * @param string $hash
     */
    public function updateLatestCommit(string $hash)
    {
        $this->hash = $hash;
    }
}
