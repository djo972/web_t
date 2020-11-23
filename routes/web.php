<?php

Route::group(['middleware' => 'guest'], function () {
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('login', 'Auth\LoginController@login');
});

Route::get('logout', 'Auth\LoginController@logout')->name('logout');

Route::get('/', 'HomeController@index')->name('index');
Route::get('/videos/{themeId}', 'HomeController@video')->name('index.video');
Route::get('/video/{videoId}', 'HomeController@show')->name('video.show');
Route::get('/streamVideo/{fileName}', 'HomeController@streamVideo')->name('video.stream');
// Route::get('/live', 'HomeController@live')->name('video.live');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/plans', 'PlanController@index')->name('plans');
    Route::get('/plans/{plan}', 'PlanController@show');
    Route::get('/token', 'PlanController@token');
    Route::post('/payment', 'PlanController@payment');
});

Route::group(['as' => 'bo.', 'middleware' => ['auth', 'access'], 'namespace' => 'BO', 'prefix' => 'bo/'], function () {
    Route::get('/themes', 'ThemeController@index')->name('theme.index');
    Route::post('/theme', 'ThemeController@create')->name('theme.create');
    Route::get('/theme/list', 'ThemeController@listThemes')->name('theme.listThemes');
    Route::get('/theme/{themeId}', 'ThemeController@show')->name('theme.show');
    Route::put('/theme/{themeId}', 'ThemeController@update')->name('theme.update');
    Route::put('/theme/showAtHome/{themeId}', 'ThemeController@showAtHome')->name('theme.showAtHome');
    Route::delete('/theme/{themeId}', 'ThemeController@delete')->name('theme.delete');
    Route::post('/theme/sort', 'ThemeController@sortThemes')->name('theme.sort');

    Route::get('/videos', 'VideoController@index')->name('video.index');
    Route::get('/video/{videoId}', 'VideoController@show')->name('video.show');
    Route::post('/video', 'VideoController@create')->name('video.create');
    Route::put('/video/{videoId}', 'VideoController@update')->name('video.update');
    Route::delete('/video/{videoId}', 'VideoController@delete')->name('video.delete');
    Route::put('/video/showAtHome/{videoId}', 'VideoController@showAtHome')->name('video.showAtHome');
    Route::put('/video/showShareLinks/{videoId}', 'VideoController@showShareLinks')->name('video.showShareLinks');
    Route::post('/video/upload', 'VideoController@upload')->name('video.upload');
    Route::post('/video/ordering', 'VideoController@updateOrder')->name('video.updateOrder');

    Route::get('/barker', 'BrakerController@index')->name('barker.index');
    Route::get('/barker/{barkerId}', 'BrakerController@show')->name('barker.show');
    Route::post('/braker', 'BrakerController@create')->name('barker.create');
    Route::put('/braker/{brakerId}', 'BrakerController@update')->name('barker.update');
    Route::put('/barker/showShareLinks/{barkerId}', 'BrakerController@showShareLinks')->name('barker.showShareLinks');

    Route::get('/users', 'UserController@index')->name('user.index');
    Route::post('/user', 'UserController@create')->name('user.create');
    Route::delete('/user/{userId}', 'UserController@delete')->name('user.delete');
    Route::get('/user/excel', 'UserController@importExcel');
    Route::post('/user/importExcel', 'UserController@importExcel')->name('user.excel');

    Route::get('/parameters', 'ParametersController@index')->name('parameters.index');
    Route::post('/parameters/update', 'ParametersController@update')->name('parameters.update');
});
