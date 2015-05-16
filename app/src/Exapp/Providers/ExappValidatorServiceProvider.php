<?php

namespace Exapp\Providers;

use Illuminate\Support\ServiceProvider;

class ExappValidatorServiceProvider extends ServiceProvider
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

        $this->bootValidators();
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->registerValidators();
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
     * Register custom validator rules.
     */
    private function bootValidators()
    {
        $this->app->validator->resolver(function ($translator, $data, $rules, $messages) {
            return new \Exapp\Validators\MessageRulesValidator($translator, $data, $rules, $messages);
        });
    }

    /**
     * Register custom validators.
     */
    private function registerValidators()
    {
        $this->app->bind('Exapp\Validators\MessageValidatorInterface', function () {
            return new \Exapp\Validators\MessageValidator();
        });
    }
}
