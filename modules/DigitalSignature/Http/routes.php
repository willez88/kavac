<?php

Route::group(
    ['middleware' => ['web', 'auth', 'verified'],
    'prefix' => 'digitalsignature',
    'namespace' => 'Modules\DigitalSignature\Http\Controllers'],
    function () {
        Route::get('/', 'DigitalSignatureController@index')->name('digitalsignature');
        Route::get('fileprofile', function () {
    		return view('digitalsignature::fileprofile');
		})->name('fileprofile');
        Route::post('signprofilestore', 'DigitalSignatureController@store')->name('signprofilestore');
        Route::get('certificateDetails', 'DigitalSignatureController@getCertificate')->name('certificateDetails');
        Route::post('updateCertificate', 'DigitalSignatureController@update')->name('updateCertificate');
        Route::post('signFile', 'DigitalSignatureController@signFile')->name('signFile');
        Route::get('verifysign', 'DigitalSignatureController@verifysign')->name('verifysign');
        Route::get('listCertificate', 'DigitalSignatureController@listCertificate')->name('listCertificate');
        Route::get('deleteCertificate', 'DigitalSignatureController@destroy')->name('deleteCertificate');
        Route::get('getFile/{filename}', 'DigitalSignatureController@getFile')->name('getFile');
        Route::get('validateAuthentication', 'DigitalSignatureController@validateAuthentication')->name('validateAuthentication');
    }
);




