<?php

Route::group(['middleware' => 'web', 'prefix' => 'accounting', 'namespace' => 'Modules\Accounting\Http\Controllers'], function()
{
    Route::get('/', 'AccountingController@index');
});
