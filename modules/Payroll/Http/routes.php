<?php

Route::group(['middleware' => 'web', 'prefix' => 'payroll', 'namespace' => 'Modules\Payroll\Http\Controllers'], function()
{
    Route::get('/', 'PayrollController@index');

    Route::get('settings', 'PayrollSettingController@index')->name('payroll.settings.index');

    Route::get('typestaff', 'TypeStaffController@index')->name('payroll.typestaff.index');
});
