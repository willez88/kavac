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
    Route::post('signFile', 'DigitalSignatureController@signFile')->name('signFile');
    Route::post('verifysignfile', 'DigitalSignatureController@verifysign')->name('verifysignfile');
});
