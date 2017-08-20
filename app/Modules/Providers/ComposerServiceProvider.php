<?php

namespace App\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Electrons\Settings\Settings;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param  Settings  $settings
     * @return void
     */
    public function boot(Settings $settings)
    {
        view()->composer('*', function ($view) use ($settings) {
            $view->with('settings', $settings);

            $view->with('stage', $this->app->make('stage.current'));
        });
    }
}
