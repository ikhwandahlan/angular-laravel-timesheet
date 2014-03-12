<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('', 'FrontController@start');

Route::group(['prefix' => 'login'], function () {

	Route::get('', 'FrontController@login');
	Route::post('', 'FrontController@loginDo');
});

Route::get('logout', 'FrontController@logout');
/* User views */
Route::get('views/{view}', function ($view) {

	return View::make('views.' . $view, ['scope' => 'user']);
});

Route::group(['prefix' => 'admin'], function () {

	Route::get('', 'AdminController@start');
	Route::get('views/{view}', function ($view) {

		return View::make('views.' . $view, ['scope' => 'admin']);
	});

	/* App API */
	Route::resource('user', 'UserController');

	/* App API */
	Route::resource('attendance', 'AttendanceController');

	/* App API */
	Route::resource('roles', 'RolesController');


	/* App API */
	Route::resource('payment', 'PaymentController');
});

/* App API */
Route::resource('payment', 'PaymentController');

/* App API */
Route::resource('attendance', 'AttendanceController');