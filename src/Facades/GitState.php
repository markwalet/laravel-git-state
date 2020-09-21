<?php

namespace MarkWalet\GitState\Facades;

use Illuminate\Support\Facades\Facade;
use MarkWalet\GitState\Drivers\GitDriver;

/**
 * Class GitState.
 *
 * @method static string currentBranch()
 * @method static string latestCommitHash(bool $short = false)
 * @see GitDriver
 */
class GitState extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return GitDriver::class;
    }
}
