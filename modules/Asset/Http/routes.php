<?php

Route::group(['middleware' => 'web', 'prefix' => 'asset', 'namespace' => 'Modules\Asset\Http\Controllers'], function()
{
    Route::get('/', 'AssetController@index');
});
