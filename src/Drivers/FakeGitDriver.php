<?php

namespace MarkWalet\GitState\Drivers;

use Carbon\Carbon;
use Illuminate\Support\Arr;

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
     * @var Carbon
     */
    private Carbon $timestamp;

    /**
     * @var string
     */
    private string $title;

    /**
     * @var string
     */
    private string $description;

    /**
     * GitDriverInterface constructor.
     *
     * @param array|string[] $config
     */
    public function __construct(array $config = [])
    {
        $this->branch = (string) Arr::get($config, 'branch', 'master');
        $this->hash = (string) Arr::get($config, 'hash', '');
        $this->timestamp = Carbon::createFromTimestampUTC((int) Arr::get($config, 'timestamp', 0));
        $this->title = (string) Arr::get($config, 'title', '');
        $this->description = (string) Arr::get($config, 'description', '');
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
     * Get the latest commit timestamp.
     *
     * @return Carbon
     */
    public function latestCommitTimestamp(): Carbon
    {
        return $this->timestamp;
    }

    /**
     * Get the latest commit title.
     *
     * @return string
     */
    public function latestCommitTitle(): string
    {
        return $this->title;
    }

    /**
     * Get the latest commit description.
     *
     * @return string
     */
    public function latestCommitDescription(): string
    {
        return $this->description;
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

    /**
     * Update the latest commit timestamp.
     *
     * @param int $timestamp
     */
    public function updateLatestCommitTimestamp(int $timestamp): void
    {
        $this->timestamp = Carbon::createFromTimestampUTC($timestamp);
    }

    /**
     * Update the latest commit title.
     *
     * @param string $title
     */
    public function updateLatestCommitTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Update the latest commit description.
     *
     * @param string $description
     */
    public function updateLatestCommitDescription(string $description): void
    {
        $this->description = $description;
    }
}
