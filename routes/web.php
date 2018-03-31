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
        return view('dashboard.index');
    }
    else {
    	/** Si el usuario no está autenticado muestra la página de acceso */
        return view('auth.login');
    }
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/refresh-captcha', 'Auth\LoginController@refreshCaptcha');

Route::group(['middleware' => 'auth'], function() {
	/** Ruta para acceder a las imágenes almacenadas por la aplicación */
    Route::get('storage/pictures/{image}', function($image) {
        $path = storage_path('pictures/' . $image);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    });
});

Route::group(['middleware' => 'role:admin'], function() {
    Route::get('/settings', function() {
        return view('admin.settings');
    })->name('settings');
});