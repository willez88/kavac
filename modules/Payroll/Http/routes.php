<?php

Route::group(['middleware' => 'web', 'prefix' => 'payroll', 'namespace' => 'Modules\Payroll\Http\Controllers'], function()
{
    Route::get('/', 'PayrollController@index');
});
