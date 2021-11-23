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

    /* Ruta Visualizar ventana principal del módulo de firma electrónica */
    Route::get('/', 'DigitalSignatureController@index')->name('digitalsignature');

    /* Ruta para cargar el certificado firmante del usuario */
    Route::post('signprofilestore', 'DigitalSignatureController@store')->name('signprofilestore');


    /**
    * ------------------------------------------------------------------
    * Rutas del crud que gestiona los certificados firmantes del usuario
    * ------------------------------------------------------------------
    */

   /* Ruta Visualizar detalles del certificado firmante del usuario */
    Route::get('certificateDetails', 'DigitalSignatureController@getCertificate')->name('certificateDetails');

    /* Ruta Actualizar el certificado firmante del usuario */
    Route::post('updateCertificate', 'DigitalSignatureController@update')->name('updateCertificate');

    /* Ruta Eliminar el certificado firmante del usuario */
    Route::get('deleteCertificate', 'DigitalSignatureController@destroy')->name('deleteCertificate');

    /* Ruta para cargar certificado firmante del usuario */
    Route::get('fileprofile', function () {
        return view('digitalsignature::fileprofile');
    })->name('fileprofile');


    /**
    * -------------------------------------------------
    * Rutas para realizar firma electrónica del usuario
    * -------------------------------------------------
    */

    /* Ruta para realizar la firma de documento PDF firmados */
    Route::post('signFile', 'DigitalSignatureController@signFile')->name('signFile');

    /* Ruta para visualizar el interfaz para firmar documento PDF */
    Route::get('viewSignfile', function () {
        return view('digitalsignature::viewSignfile', ['signfile' => 'false']);
    })->name('digitalsignature.viewSignfile');


    /**
    * --------------------------------------------------------------------
    * Rutas para realizar la verificación de firma electrónica del usuario
    * --------------------------------------------------------------------
    */

    /* Ruta para realizar la verificación de la firma de documento PDF firmados */
    Route::post('verifysignfile', 'DigitalSignatureController@verifySign')->name('verifysignfile');

    /* Ruta para visualizar el interfaz para verificar firma de documento PDF */
    Route::get('viewVerifySignfile', function () {
        return view('digitalsignature::viewVerifySignfile', ['verifyFile' => 'false']);
    })->name('viewVerifySignfile');

    /* Ruta para mostrar la lista de usuario con certificados electrónicos  */
    Route::get('listCertificate', 'DigitalSignatureController@listCertificate')->name('listCertificate');

    /* Ruta para descargar documento PDF firmado */
    Route::get('getFile/{filename}', 'DigitalSignatureController@getFile')->name('getFile');


    /**
    * ---------------------------------------------
    * Rutas para los componentes firmar y verificar
    * ---------------------------------------------
    */

    /* Ruta para realizar la firma de documento PDF firmados */
    Route::post('apiSignFile', 'DigitalSignatureController@signFileApi')->name('apiSignFile');

    /* Ruta para realizar la verificación de la firma de documento PDF firmados */
    Route::post('apiVerifysignfile', 'DigitalSignatureController@verifySignApi')->name('apiVerifysignfile');

    /* Ruta para descargar documento PDF firmado */
    Route::get('apiGetFile/{filename}', 'DigitalSignatureController@getFile')->name('apiGetFile');

    /**
    * ---------------------------------------------
    * Rutas para validar la autenticación
    * ---------------------------------------------
    */

    /* Ruta para validar la autenticación */
    Route::get('validateAuth', 'DigitalSignatureController@validateAuth')->name('validateAuth');

    /* Ruta para validar la autenticación API */
    Route::post('validateAuthApi', 'DigitalSignatureController@validateAuthApi')->name('validateAuthApi');
});
