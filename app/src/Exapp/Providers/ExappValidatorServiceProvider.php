<?php

namespace Exapp\Providers;

use Illuminate\Support\ServiceProvider;

class ExappValidatorServiceProvider extends ServiceProvider
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

        $this->registerValidators();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
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
     * Register custom validators.
     */
    private function registerValidators()
    {
        $this->app->validator->resolver(function ($translator, $data, $rules, $messages) {
            return new \Exapp\Validators\MessageValidator($translator, $data, $rules, $messages);
        });
    }
}
