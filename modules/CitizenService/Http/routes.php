<?php

Route::group(['middleware' => 'web', 'prefix' => 'citizenservice', 'namespace' => 'Modules\CitizenService\Http\Controllers'], function()
{
    Route::get('/', 'CitizenServiceController@index');
});
