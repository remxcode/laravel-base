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
        if (App::isLocal()) {
            $app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }
    }
}
