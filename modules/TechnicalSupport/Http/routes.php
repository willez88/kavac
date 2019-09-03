<?php

Route::group(['middleware' => 'web', 'prefix' => 'technicalsupport', 'namespace' => 'Modules\TechnicalSupport\Http\Controllers'], function()
{
    Route::get('/', 'TechnicalSupportController@index');
});
