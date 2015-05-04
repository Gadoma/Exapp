<?php

namespace Exapp\Providers;

use Illuminate\Support\ServiceProvider;

class ExappTransformerServiceProvider extends ServiceProvider
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
        $this->registerTransformers();
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
     * Bind transformer implementations to interfaces.
     */
    private function registerTransformers()
    {
        $this->app->bind('Exapp\Transformers\MessageWriteTransformerInterface', function () {
            return new \Exapp\Transformers\MessageWriteTransformer();
        });
    }
}
