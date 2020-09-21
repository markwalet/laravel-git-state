<?php

namespace MarkWalet\GitState\Drivers;

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
}
