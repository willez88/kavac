<?php

Route::group([
	'middleware' => ['web', 'auth'],
	'prefix' => 'asset', 
	'namespace' => 'Modules\Asset\Http\Controllers'
], function(){
    Route::get('/', 'AssetController@index');


    Route::get('clasifications', 'AssetClasificationController@index')->name('asset.clasification.index');
    Route::get('clasifications/create', 'AssetClasificationController@create')->name('asset.clasification.create');
    Route::post('clasifications/store', 'AssetClasificationController@store')->name('asset.clasification.store');




    Route::get('index', 'AssetController@index')->name('asset.index');
    Route::get('create', 'AssetController@create')->name('asset.assets.create');
    Route::post('store', 'AssetController@store')->name('asset.assets.store');
    Route::get('edit/{asset}', 'AssetController@edit')->name('asset.assets.edit');
    Route::put('update/{asset}', 'AssetController@update')->name('asset.assets.update');
    Route::delete('delete/{asset}', 'AssetController@destroy')->name('asset.assets.destroy');





    Route::get('asignation', 'AssetAsignationController@index')->name('asset.asignation.index');
    Route::get('asignation/create', 'AssetAsignationController@create')->name('asset.asignation.create');
    Route::post('asignation/store', 'AssetAsignationController@store')->name('asset.asignation.store');
    Route::get('asignation/edit/{asignation}', 'AssetAsignationController@edit')->name('asset.asignation.edit');
    Route::put('asignation/update/{asignation}', 'AssetAsignationController@update')->name('asset.asignation.update');
    Route::delete('asignation/delete/{asignation}', 'AssetAsignationController@destroy')->name('asset.asignation.destroy');



    Route::get('requests', 'AssetRequestController@index')->name('asset.requests.index');




    Route::get('/GetCategories', 'ServiceController@GetCategories');
    Route::get('/GetSubcategories/{category}', 'ServiceController@GetSubcategories');


});