<?php

namespace Kielabokkie\LaravelConceal;

use Illuminate\Support\ServiceProvider;

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
        $this->mergeConfigFrom(__DIR__.'/../config/conceal.php', 'conceal');
    }
}
