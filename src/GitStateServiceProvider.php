<?php

namespace MarkWalet\GitState;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use MarkWalet\GitState\Drivers\GitDriver;

class GitStateServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/git-state.php', 'git-state');

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
        $this->app->bind(GitStateManager::class, function (Application $app) {
            return new GitStateManager($app, $app->make(GitDriverFactory::class));
        });

        // Bind default driver to application.
        $this->app->singleton(GitDriver::class, function (Application $app) {
            /** @var GitStateManager $manager */
            $manager = $app->make(GitStateManager::class);

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
            __DIR__.'/../config/git-state.php' => $this->app->configPath('git-state.php'),
        ]);
    }
}
