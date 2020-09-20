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

Route::group(['middleware' => ['web', 'auth', 'verified'], 'prefix' => 'digitalsignature'], function () {
    Route::get('/', 'DigitalSignatureController@index')->name('digitalsignature');
    Route::get('fileprofile', function () {
        return view('digitalsignature::fileprofile');
    })->name('fileprofile');
    Route::post('signprofilestore', 'DigitalSignatureController@store')->name('signprofilestore');
    Route::get('certificateDetails', 'DigitalSignatureController@getCertificate')->name('certificateDetails');
    Route::post('updateCertificate', 'DigitalSignatureController@update')->name('updateCertificate');
    Route::get('signFile', 'DigitalSignatureController@signFile')->name('signFile');
    Route::get('verifysign', 'DigitalSignatureController@verifysign')->name('verifysign');
    Route::get('listCertificate', 'DigitalSignatureController@listCertificate')->name('listCertificate');
    Route::get('deleteCertificate', 'DigitalSignatureController@destroy')->name('deleteCertificate');
});
