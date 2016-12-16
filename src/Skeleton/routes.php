<?php

Route::group(['module'=>'Test', 'namespace' => 'YModules\Test\Controllers'], function () {
    Route::resource('route_name', 'TestController');
});
