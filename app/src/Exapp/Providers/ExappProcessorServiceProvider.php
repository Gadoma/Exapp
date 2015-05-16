<?php

namespace Exapp\Providers;

use Illuminate\Support\ServiceProvider;

class ExappProcessorServiceProvider extends ServiceProvider
{
    /**
     * @var bool Indicates if loading of the provider is deferred.
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     */
    public function boot()
    {
        include __DIR__.'/../../../routes.php';

        $this->commands('Exapp\Commands\ProcessCommand');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerProcessor();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array Provided services
     */
    public function provides()
    {
        return [];
    }

    /**
     * Register custom processor.
     */
    private function registerProcessor()
    {
        $this->app->bind('Exapp\Services\ProcessorServiceInterface', function () {
            return new \Exapp\Services\ProcessorService($this->app->make('Exapp\Repositories\CountryRepositoryInterface'));
        });

        $this->app->bind('Exapp\Commands\ProcessCommand', function () {
            return new \Exapp\Commands\ProcessCommand($this->app->make('Exapp\Services\ProcessorServiceInterface'));
        });
    }
}
