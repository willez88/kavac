<?php

Route::group(['middleware' => 'web', 'prefix' => 'sale', 'namespace' => 'Modules\Sale\Http\Controllers'], function()
{
    Route::get('/', 'SaleController@index');
});
