<?php

Route::group(
    ['middleware' => ['web', 'auth', 'verified'],
    'prefix' => 'digitalsignature',
    'namespace' => 'Modules\DigitalSignature\Http\Controllers'],
    function () {
        Route::get('/', 'DigitalSignatureController@index');
    }
);
