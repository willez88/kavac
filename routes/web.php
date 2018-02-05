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

Route::get('/', function () {
    if (Auth::check()) {
		/** Si el usuario esta autenticado redirecciona a la página del panel de control */
        //return view('dashboard.index');
        return view('home');
    }
    else {
    	/** Si el usuario no está autenticado muestra la página de acceso */
        return view('auth.login');
    }
});

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['web'])->group(function() {
	/** Rutas de gestión de acceso a usuarios */
	Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	Route::post('login', 'Auth\LoginController@login');
	Route::post('logout', 'Auth\LoginController@logout')->name('logout');

	/** Rutas para el reinicio de contraseña */
	Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset');
});

Route::middleware(['auth'])->group(function() {
	/** Rutas para el registro de usuarios */
	Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
	Route::post('register', 'Auth\RegisterController@register');
});