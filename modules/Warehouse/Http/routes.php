<?php

Route::group(['middleware' => 'web', 'prefix' => 'warehouse', 'namespace' => 'Modules\Warehouse\Http\Controllers'], function()
{
    Route::get('/', 'WarehouseController@index');
});
