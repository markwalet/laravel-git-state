<?php

namespace MarkWalet\GitState\Tests;

use Illuminate\Foundation\Application;
use MarkWalet\GitState\GitServiceProvider;
use Orchestra\Testbench\TestCase;

class LaravelTestCase extends TestCase
{
    /**
     * Get package providers.
     *
     * @param Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            GitServiceProvider::class,
        ];
    }
}
