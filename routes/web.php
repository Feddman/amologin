<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group(['domain' => 'api.amo.rocks'], function() {
    
    Route::redirect('/', 'https://apitest.amo.rocks/');

});

Route::group(['domain' => 'amo.rocks'], function() {
    
    Route::redirect('/', 'https://login.amo.rocks/')->name('home');
    Route::get('/{link}', 'RedirectController@go');

});

Route::group(['domain' => 'login.amo.rocks'], function() {

	Route::group(['middleware' => 'auth'], function() {
		
		Route::redirect('/', '/me', 301);
		Route::redirect('/home', '/me', 301);
		Route::get('/me', 'DashboardController@show')->name('home');
		Route::get('/users/{user}/profile', 'UserController@profile');
		Route::patch('/users/{user}/profile', 'UserController@profile_update');

		Route::group(['middleware' => 'admin'], function() {
			
			Route::resource('clients', 'MyClientController', ['except' => ['edit', 'update']]);
			Route::get('clients/{client}/toggle', 'MyClientController@toggle_dev');
			
			Route::get('groups/create/batch', 'BatchGroupController@create');
			Route::post('groups/batch', 'BatchGroupController@store');
			Route::delete('/groups', 'GroupController@destroy');
			Route::resource('groups', 'GroupController', ['except' => ['show', 'destroy']]);

			Route::post('/users/import', 'ImportController@upload');
			Route::get('/users/import', 'ImportController@show');
			Route::delete('/users', 'UserController@destroy');
			Route::resource('users', 'UserController', ['except' => ['show', 'destroy']]);

			Route::delete('/links', 'LinkController@destroy');
			Route::resource('links', 'LinkController', ['except' => ['show', 'edit', 'update', 'destroy']]);

		});
	});

	Route::view('passwords', 'auth.passwords');
	Route::get('login', '\App\Http\Controllers\Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', '\App\Http\Controllers\Auth\LoginController@login');
	Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');

	// Password Reset Routes...
	Route::get('password/reset', '\App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email', '\App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', '\App\Http\Controllers\Auth\ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('password/reset', '\App\Http\Controllers\Auth\ResetPasswordController@reset');

});
