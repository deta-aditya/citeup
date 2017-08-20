<?php

namespace App\Modules\Providers;

use Illuminate\Support\ServiceProvider;
use App\Modules\Electrons\Stages\StageService;

class CurrentStageServiceProvider extends ServiceProvider
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
        $this->app->singleton('stage.current', function ($app) {
            return StageService::current();
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ 'stage.current' ];
    }
}
