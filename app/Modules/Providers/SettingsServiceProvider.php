<?php

namespace App\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Electrons\Settings\Settings;

class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Settings::class, function ($app) {
            return new Settings();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [Settings::class];
    }
}
