<?php

Route::group(['module'=>'Test', 'namespace' => 'Modules\Test\Controllers'], function () {
    Route::resource('route_name', 'TestController');
});
