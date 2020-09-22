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

Route::group(
    ['middleware' => ['web', 'auth', 'verified'], 
    'prefix' => 'digitalsignature'], 
    function () {

        Route::get('/', 'DigitalSignatureController@index')->name('digitalsignature');


        Route::get('fileprofile', function () {
            return view('digitalsignature::fileprofile');
        })->name('fileprofile');

        Route::post('signprofilestore', 'DigitalSignatureController@store')->name('signprofilestore');

        /**
        * ----------------------------------------------------------------------
        * Rutas del crud que gestiona los certificados firmantes del usuario 
        * --------------------------------------------------------------------
        */
       
       /* Visualizar detalles del certificado firmante del usuario */
        Route::get('certificateDetails', 'DigitalSignatureController@getCertificate')->name('certificateDetails');
        /* Actualizar el certificado firmante del usuario */
        Route::post('updateCertificate', 'DigitalSignatureController@update')->name('updateCertificate');
        /* Ruta para  documento PDF firmados */
        Route::get('deleteCertificate', 'DigitalSignatureController@destroy')->name('deleteCertificate');

        /* Ruta para realizar la firma de documento PDF firmados */
        Route::post('signFile', 'DigitalSignatureController@signFile')->name('signFile');

        /* Ruta para realizar la verificación de la firma de documento PDF firmados */
        Route::post('verifysign', 'DigitalSignatureController@verifysign')->name('verifysign');

        /* Ruta para realizar la verificación de la firma de documento PDF firmados */
        Route::get('listCertificate', 'DigitalSignatureController@listCertificate')->name('listCertificate');


        /* Ruta para visualizar el interfaz para firmar documento PDF */
        Route::get('signfile', function () {
            return view('digitalsignature::signfile', ['signfile' => 'false']);
        })->name('signfile');

        /* Ruta para visualizar el interfaz para verificar firma de documento PDF */
        Route::get('verifysignfile', function () {
            return view('digitalsignature::verifysignfile', ['verifyFile' => 'false']);
        })->name('verifysignfile');
        
        /* Ruta para descargar documento PDF firmados */
        Route::get('getFile/{filename}', 'DigitalSignatureController@getFile')->name('getFile');
});
