<?php

Route::group(['middleware' => 'web', 'prefix' => 'purchase', 'namespace' => 'Modules\Purchase\Http\Controllers'], function()
{
    Route::get('/', 'PurchaseController@index');
});
