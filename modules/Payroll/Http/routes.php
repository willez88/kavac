<?php

Route::group(['middleware' => 'web', 'prefix' => 'payroll', 'namespace' => 'Modules\Payroll\Http\Controllers'], function()
{
    Route::get('/', 'PayrollController@index');

    Route::get('settings', 'PayrollSettingController@index')->name('payroll.settings.index');

    //Route::get('stafftype', 'StaffTypeController@index')->name('payroll.stafftype.index');
    //Route::get('stafftype/create', 'StaffTypeController@create')->name('payroll.stafftype.create');
    //Route::get('stafftype/store', 'StaffTypeController@store')->name('payroll.stafftype.store');

    Route::resource('staff-types', 'StaffTypeController');
});
