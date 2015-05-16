<?php

namespace Exapp\Providers;

use Illuminate\Support\ServiceProvider;

class ExappTransformerServiceProvider extends ServiceProvider
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
     * @return array Provided services
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
        $this->app->bind('Exapp\Transformers\CollectionToArrayTransformerInterface', function () {
            return new \Exapp\Transformers\CollectionToArrayTransformer();
        });

        $this->app->bind('Exapp\Transformers\DateTimeFormatTransformerInterface', function () {
            return new \Exapp\Transformers\DateTimeFormatTransformer();
        });

        $this->app->bind('Exapp\Transformers\MessageWriteTransformerInterface', function () {
            return new \Exapp\Transformers\MessageWriteTransformer($this->app->make('Exapp\Transformers\DateTimeFormatTransformerInterface'));
        });

        $this->app->bind('Exapp\Transformers\CountryReadTransformerInterface', function () {
            return new \Exapp\Transformers\CountryReadTransformer();
        });
    }
}
