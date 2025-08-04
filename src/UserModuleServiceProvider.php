<?php

namespace Christiantomax\UserModule;

use Illuminate\Support\ServiceProvider;

class UserModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Routes
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');

        // Migrations
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        // Views (optional)
        $this->loadViewsFrom(__DIR__.'/resources/views', 'user-module');

        $this->publishes([
            __DIR__.'/config/filament-shield.php' => config_path('filament-shield.php'),
        ], 'filament-shield-config');

        // Optional: merge config so it works even without publishing
        $this->mergeConfigFrom(
            __DIR__.'/config/filament-shield.php',
            'filament-shield'
        );
        
        // php artisan vendor:publish --tag="filament-shield-config"
        // 'auth_provider_model' => [
        //     'fqcn' => 'App\\Models\\User',
        // ],
        // php artisan shield:setup
        // php artisan shield:install admin
    }

    public function register()
    {
        //
    }
}

