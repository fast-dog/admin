<?php

Route::group([
    'prefix' => config('core.admin_path', 'admin'),
    'middleware' => ['web'],
], function () {
    /**
     * Служебные маршруты по умолчанию
     */
    Route::get('/', '\FastDog\Admin\Http\Controllers\AdminController@getIndex');
    Route::get('/login', '\FastDog\Admin\Http\Controllers\AdminController@getLogin');
    Route::post('/login', '\FastDog\Admin\Http\Controllers\AdminController@postLogin');
    Route::get('/menu', '\FastDog\Admin\Http\Controllers\AdminController@getMenu');
    Route::get('/desktop', '\FastDog\Admin\Http\Controllers\AdminController@getDesktop');
    Route::post('/desktop-sort', '\FastDog\Admin\Http\Controllers\AdminController@postDesktopSort');

});