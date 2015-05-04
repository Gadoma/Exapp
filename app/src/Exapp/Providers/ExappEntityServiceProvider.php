<?php

namespace Exapp\Providers;

use Illuminate\Support\ServiceProvider;

class ExappEntityServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        include __DIR__.'/../../../routes.php';
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerRepositories();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    /**
     * Bind repository implementations to interfaces.
     */
    private function registerRepositories()
    {
        $this->app->bind('Exapp\Repositories\MessageRepositoryInterface', function () {
            return new \Exapp\Repositories\EloquentMessageRepository($this->app->make('Exapp\Models\Message'));
        });
    }
}
