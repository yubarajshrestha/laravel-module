<?php

namespace YubarajShrestha\YM;

use Illuminate\Support\Str;

/**
 * ModuleProvider.
 *
 * This make sures that each of the modules are properly loaded
 * i.e. with their routes, views etc.
 *
 * @author Yubaraj Shrestha
 */
class YMModuleProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Will make sure that the required modules have been fully loaded.
     *
     * @return void
     */
    public function boot()
    {
        // For each of the registered modules, include their routes and Views
        $modules = config('module.modules');

        try {
            foreach ($modules as $module) {
                // Load the routes for each of the modules
                if (file_exists(base_path().'/modules/'.Str::singular($module).'/routes.php')) {
                    include base_path().'/modules/'.Str::singular($module).'/routes.php';
                }

                // Load the views
                if (is_dir(base_path().'/modules/'.Str::singular($module).'/Views')) {
                    $this->loadViewsFrom(base_path().'/modules/'.Str::singular($module).'/Views', strtolower(Str::singular($module)));
                }
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }

    public function register()
    {
    }
}
