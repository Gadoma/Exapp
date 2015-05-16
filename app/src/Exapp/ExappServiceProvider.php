<?php

namespace Exapp;

use Illuminate\Support\ServiceProvider;

class ExappServiceProvider extends ServiceProvider
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
        include __DIR__.'/../../routes.php';
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerServices();
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
     * Register Exapp Services.
     */
    private function registerServices()
    {
        $this->app->register('Exapp\Providers\ExappEntityServiceProvider');
        $this->app->register('Exapp\Providers\ExappTransformerServiceProvider');
        $this->app->register('Exapp\Providers\ExappValidatorServiceProvider');
        $this->app->register('Exapp\Providers\ExappProcessorServiceProvider');
    }
}
