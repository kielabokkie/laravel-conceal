<?php

namespace Kielabokkie\LaravelConceal;

use Illuminate\Support\ServiceProvider;
use Kielabokkie\LaravelConceal\Concealer;

class ConcealServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/conceal.php' => config_path('conceal.php'),
            ], 'config');
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // Merge the custom config with the package one
        $this->mergeConfigFrom(__DIR__.'/../config/conceal.php', 'conceal');

        // Setup the facade
        $this->app->bind('concealer', function ($app) {
            return new Concealer;
        });
    }
}
