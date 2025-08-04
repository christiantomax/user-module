<?php

namespace Christiantomax\UserModule;

use Illuminate\Support\ServiceProvider;

class UserModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load core package functionality
        $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->loadViewsFrom(__DIR__.'/resources/views', 'user-module');

        // Config auto merge (optional, works without publish)
        $this->mergeConfigFrom(__DIR__.'/config/user-module.php', 'user-module');
        $this->mergeConfigFrom(__DIR__.'/config/filament-shield.php', 'filament-shield');

        // Publish config files
        $this->publishes([
            __DIR__.'/config/user-module.php' => config_path('user-module.php'),
        ], 'user-module-config');

        $this->publishes([
            __DIR__.'/config/filament-shield.php' => config_path('filament-shield.php'),
        ], 'filament-shield-config');

        // Publish app folder (controllers, models, filament, etc.)
        $this->publishes([
            __DIR__.'/app' => app_path(),
        ], 'user-module-app');

        // Publish routes (web/api/etc)
        $this->publishes([
            __DIR__.'/routes' => base_path('routes/vendor/user-module'),
        ], 'user-module-routes');

        // Publish views
        $this->publishes([
            __DIR__.'/resources/views' => resource_path('views/vendor/user-module'),
        ], 'user-module-views');

        // Publish migrations
        $this->publishes([
            __DIR__.'/database/migrations' => database_path('migrations'),
        ], 'user-module-migrations');
        
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

