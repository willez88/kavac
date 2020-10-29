<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'middleware' => 'auth:api', 'prefix' => 'digitalsignature'
], function () {
	
	/* Ruta para realizar la firma de documento PDF firmados */
    Route::post('signFile', 'DigitalSignatureController@signFile')->name('apiSignFile');

    /* Ruta para realizar la verificación de la firma de documento PDF firmados */
    Route::post('verifysignfile', 'DigitalSignatureController@verifysign')->name('apiVerifysignfile');

    /* Ruta para descargar documento PDF firmado */
        Route::get('getFile/{filename}', 'DigitalSignatureController@getFile')->name('apiGetFile');
});
