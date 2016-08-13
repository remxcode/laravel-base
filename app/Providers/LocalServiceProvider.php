<?php

namespace App\Providers;

use App;
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
            $app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        if (App::isLocal()) {
            $app->register(\Laracasts\Generators\GeneratorsServiceProvider::class);
        }
    }
}
