<?php

namespace MarkWalet\GitState;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use MarkWalet\GitState\Drivers\GitDriver;

class GitServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/git-state.php', 'git');

        $this->registerGitServices();
    }

    /**
     * Register Git services.
     */
    private function registerGitServices(): void
    {
        // Bind factory to application.
        $this->app->bind(GitDriverFactory::class, GitDriverFactory::class);

        // Bind manager to application.
        $this->app->bind(GitManager::class, function (Application $app) {
            return new GitManager($app, $app->make(GitDriverFactory::class));
        });

        // Bind default driver to application.
        $this->app->bind(GitDriver::class, function (Application $app) {
            /** @var GitManager $manager */
            $manager = $app->make(GitManager::class);

            return $manager->driver();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/git-state.php' => $this->app->configPath('git-state.php'),
        ]);
    }
}
