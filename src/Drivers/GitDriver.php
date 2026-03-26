<?php

namespace MarkWalet\GitState\Drivers;

use Carbon\Carbon;

interface GitDriver
{
    /**
     * GitDriverInterface constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = []);

    /**
     * Get the current branch.
     *
     * @return string
     */
    public function currentBranch(): string;

    /**
     * Get the latest commit hash.
     *
     * @param bool $short
     * @return string
     */
    public function latestCommitHash(bool $short = false): string;

    /**
     * Get the latest commit timestamp.
     *
     * @return Carbon
     */
    public function latestCommitTimestamp(): Carbon;

    /**
     * Get the latest commit title.
     *
     * @return string
     */
    public function latestCommitTitle(): string;

    /**
     * Get the latest commit description.
     *
     * @return string
     */
    public function latestCommitDescription(): string;
}
