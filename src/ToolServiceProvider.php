<?php

namespace Laravel\Nova\PennantTool;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class ToolServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->booted(function () {
            $this->routes();
        });

        Nova::serving(function (ServingNova $event) {
            Nova::remoteScript(mix('tool.js', 'vendor/nova-pennant'));
        });

        $this->publishes([
            __DIR__.'/../dist' => public_path('vendor/nova-pennant'),
        ], ['nova-assets', 'laravel-assets']);
    }

    /**
     * Register the tool's routes.
     */
    protected function routes(): void
    {
        /** @phpstan-ignore method.notFound */
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(config('nova.api_middleware', []))
            ->prefix('/nova-vendor/nova-pennant')
            ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
