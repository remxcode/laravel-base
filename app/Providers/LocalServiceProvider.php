<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class LocalServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     */
    public function register()
    {
        $app = app();
        if ($app->environment('local')) {
            $app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
            $app->register(\Laracasts\Generators\GeneratorsServiceProvider::class);
        }
    }
}
