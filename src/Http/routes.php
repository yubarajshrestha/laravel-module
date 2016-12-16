<?php

Route::group(['namespace' => 'YubarajShrestha\YM\Controllers', 'prefix' => 'ym'], function () {
    Route::get('/', 'YMController@index')->name('ym');
    Route::post('/', 'YMController@make')->name('make-module');
    Route::get('/{id}', 'YMController@destroy')->name('delete-module');
});
