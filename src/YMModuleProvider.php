<?php

namespace YubarajShrestha\YM;
use File;
/**
* ModuleProvider
*
* This make sures that each of the modules are properly loaded
* i.e. with their routes, views etc.
*
* @author Yubaraj Shrestha
* @package YModules
*/
class YMModuleProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Will make sure that the required modules have been fully loaded
     * @return void
     */
    public function boot()
    {
        // For each of the registered modules, include their routes and Views
        $modules = config("module.modules");
        try {
            while (list(,$module) = each($modules)) {
                // Load the routes for each of the modules
                if(file_exists(base_path().'/YModules/'.str_singular($module).'/routes.php')) {
                    include base_path().'/YModules/'.str_singular($module).'/routes.php';
                }

                // Load the views
                if(is_dir(base_path(). '/YModules/'.str_singular($module).'/Views')) {
                    $this->loadViewsFrom(base_path(). '/YModules/'.str_singular($module).'/Views', strtolower(str_singular($module)));
                }
            }
        } catch(\Exception $e) {
            //
        }
    }
    public function register() {}
}
