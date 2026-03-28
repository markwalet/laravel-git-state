<?php

namespace MarkWalet\GitState\Drivers;

use Carbon\Carbon;
use Illuminate\Support\Arr;

class FakeGitDriver implements GitDriver
{
    private string $branch;

    private string $hash;

    private Carbon $timestamp;

    private string $title;

    private string $description;

    /**
     * GitDriverInterface constructor.
     *
     * @param array<string, scalar> $config
     */
    public function __construct(array $config = [])
    {
        $this->branch = (string) Arr::get($config, 'branch', 'master');
        $this->hash = (string) Arr::get($config, 'hash', '');
        $this->timestamp = Carbon::createFromTimestampUTC((int) Arr::get($config, 'timestamp', 0));
        $this->title = (string) Arr::get($config, 'title', '');
        $this->description = (string) Arr::get($config, 'description', '');
    }

    public function currentBranch(): string
    {
        return $this->branch;
    }

    public function latestCommitHash(bool $short = false): string
    {
        return $short
            ? mb_substr($this->hash, 0, 7)
            : trim($this->hash);
    }

    public function latestCommitTimestamp(): Carbon
    {
        return $this->timestamp;
    }

    public function latestCommitTitle(): string
    {
        return $this->title;
    }

    public function latestCommitDescription(): string
    {
        return $this->description;
    }

    public function updateCurrentBranch(string $branch): void
    {
        $this->branch = $branch;
    }

    public function updateLatestCommit(string $hash): void
    {
        $this->hash = $hash;
    }

    public function updateLatestCommitTimestamp(int $timestamp): void
    {
        $this->timestamp = Carbon::createFromTimestampUTC($timestamp);
    }

    public function updateLatestCommitTitle(string $title): void
    {
        $this->title = $title;
    }

    public function updateLatestCommitDescription(string $description): void
    {
        $this->description = $description;
    }
}
