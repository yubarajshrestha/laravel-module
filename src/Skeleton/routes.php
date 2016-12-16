<?php
Route::group(array('module'=>'Test','namespace' => 'YModules\Test\Controllers'), function() {

    Route::resource('route_name', 'TestController');

});
