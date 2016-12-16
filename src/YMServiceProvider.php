<?php

namespace YubarajShrestha\YM;

use Illuminate\Support\ServiceProvider;
use Carbon\Carbon;
use File;

class YMServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    	// loading the route files
        $this->loadRoutesFrom(__DIR__ . '/Http/routes.php');
		// path for views
        $this->loadViewsFrom(__DIR__ . '/Views', 'ym');
        // loading the migrations
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
        // define files which are going to be published
        if(!File::isDirectory(base_path() . '/YModules'))
            File::makeDirectory(base_path() . '/YModules');
		$this->publishes([
			__DIR__ . '/Skeleton/module-config.php' => base_path('config/module.php'),
			__DIR__ . '/Skeleton/layout.php' => resource_path('views/module.blade.php'),
		]);


    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('ym', function () {
            return new ym;
        });
    }
}
