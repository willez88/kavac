<?php

Route::group(['middleware' => 'web', 'prefix' => 'digitalsignature', 'namespace' => 'Modules\DigitalSignature\Http\Controllers'], function()
{
    Route::get('/', 'DigitalSignatureController@index');
});
