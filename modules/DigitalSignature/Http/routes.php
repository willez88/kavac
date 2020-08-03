<?php

Route::group(
    ['middleware' => ['web', 'auth', 'verified'],
    'prefix' => 'digitalsignature',
    'namespace' => 'Modules\DigitalSignature\Http\Controllers'],
    function () {
        Route::get('/', 'DigitalSignatureController@index')->name('digitalsignature');
        Route::get('fileprofile', function() {
    		return view('digitalsignature::fileprofile');
		})->name('fileprofile');
        Route::post('signprofilestore', 'DigitalSignatureController@store')->name('signprofilestore');
    }
);




