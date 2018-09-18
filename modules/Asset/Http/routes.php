<?php

/**
 * -----------------------------------------------------------------------
 * Grupo de rutas para la gestión de Bienes Institucionales
 * -----------------------------------------------------------------------
 *
 * Permite gestionar los bienes institucionales y 
 * el acceso a los distintos discos establecidos en la configuración de 
 * config/filesystems.php
 */

Route::group(['middleware' => 'web', 'prefix' => 'asset', 'namespace' => 'Modules\Asset\Http\Controllers'], function()
{
    Route::get('/', 'AssetController@index');

    Route::get('settings', 'AssetSettingController@index')->name('asset.setting.index');

	/**
	 * Rutas para gestionar el Ingreso de Bienes Institucionales 
	 */

    Route::get('index', 'AssetController@index')->name('asset.index');
    Route::get('create', 'AssetController@create')->name('asset.create');
    Route::post('store', 'AssetController@store')->name('asset.store');
    Route::get('edit/{asset}', 'AssetController@edit')->name('asset.edit');
    Route::put('update/{asset}', 'AssetController@update')->name('asset.update');
    Route::delete('delete/{asset}', 'AssetController@destroy')->name('asset.destroy');

    /**
     * Rutas para gestionar las Asignaciones de Bienes Institucionales 
     */

    Route::get('asignations', 'AssetAsignationController@index')
                ->name('asset.asignation.index');
    Route::get('asignations/create', 'AssetAsignationController@create')
                ->name('asset.asignation.create');
    Route::get('asignations/asset/{asset}', 'AssetAsignationController@asset_assign')
                ->name('asset.asignation.asset_assign');            
    Route::post('asignations/store', 'AssetAsignationController@store')
                ->name('asset.asignation.store');
    Route::get('asignations/edit/{asignation}', 'AssetAsignationController@edit')
                ->name('asset.asignation.edit');
    Route::put('asignations/update/{asignation}', 'AssetAsignationController@update')
                ->name('asset.asignation.update');
    Route::delete('asignations/delete/{asignation}', 'AssetAsignationController@destroy')
                ->name('asset.asignation.destroy');

    /**
     * Rutas para gestionar las Desincorporaciones de Bienes Institucionales 
     */

    Route::get('disincorporations', 'AssetDisincorporationController@index')
                ->name('asset.disincorporation.index');
    Route::get('disincorporations/create', 'AssetDisincorporationController@create')
                ->name('asset.disincorporation.create');
    Route::get('disincorporations/asset/{asset}', 'AssetDisincorporationController@asset_disassign')
                ->name('asset.disincorporation.asset_disassign');
    Route::post('disincorporations/store', 'AssetDisincorporationController@store')
                ->name('asset.disincorporation.store');
    Route::get('disincorporations/edit/{disincorporation}', 'AssetDisincorporationController@edit')
                ->name('asset.disincorporation.edit');
    Route::put('disincorporations/update/{disincorporation}', 'AssetDisincorporationController@update')
                ->name('asset.disincorporation.update');
    Route::delete('disincorporations/delete/{disincorporation}', 'AssetDisincorporationController@destroy')
                ->name('asset.disincorporation.destroy');

    /**
     * Rutas para gestionar las Solicitudes de Bienes Institucionales 
     */

    Route::get('requests', 'AssetRequestController@index')->name('asset.request.index');
    Route::get('request/create', 'AssetRequestController@create')->name('asset.request.create');
    Route::post('requests/store', 'AssetRequestController@store')->name('asset.request.store');
    Route::put('requests/edit/{request}', 'AssetRequestController@update')->name('asset.request.edit');
    Route::delete('requests/delete/{request}', 'AssetRequestController@destroy')->name('asset.request.delete');




    /**
     * Rutas para gestionar los Servicios del Modulo de Bienes Institucionales
     */

    Route::get('vue-list', 'ServiceController@vueListTypes')->name('asset.services.vuelist');
    Route::get('get-types', 'ServiceController@GetTypes')->name('asset.services.types');
    Route::get('get-categories/{type}', 'ServiceController@GetCategories')->name('asset.services.categories');
    Route::get('get-subcategories/{category}', 'ServiceController@GetSubcategories')->name('asset.services.subcategories');


    /**
     * Rutas para gestionar los tipos de bienes
     */

    Route::get('types', 'AssetTypeController@index');
    Route::post('types/store', 'AssetTypeController@store');
    Route::put('types/edit/{type}', 'AssetTypeController@update');
    Route::delete('types/delete/{type}', 'AssetTypeController@destroy');

    /**
     * Rutas para gestionar las categorias de bienes
     */
    
    Route::get('categories', 'AssetCategoryController@index');
    Route::post('categories/store', 'AssetCategoryController@store');
    Route::put('categories/edit/{category}', 'AssetCategoryController@update');
    Route::delete('categories/delete/{category}', 'AssetCategoryController@destroy');

    /**
     * Rutas para gestionar las subcategorias de bienes
     */
    
    Route::get('subcategories', 'AssetSubcategoryController@index');
    Route::post('subcategories/store', 'AssetSubcategoryController@store');
    Route::put('subcategories/edit/{subcategory}', 'AssetSubcategoryController@update');
    Route::delete('subcategories/delete/{subcategory}', 'AssetSubcategoryController@destroy');

    /**
     * Rutas para gestionar las categorias especificas de bienes
     */

    Route::get('specific', 'AssetSpecificCategoryController@index');
    Route::post('specific/store', 'AssetSpecificCategoryController@store');
    Route::put('specific/edit/{specific}', 'AssetSpecificCategoryController@update');
    Route::delete('specific/delete/{specific}', 'AssetSpecificCategoryController@destroy');

    /**
     * Rutas para gestionar las clasificacion de bienes (Configuración principal)
     */

    Route::get('clasifications', 'AssetCategoryController@index');
    Route::post('clasifications/store', 'AssetCategoryController@store');
    Route::put('clasifications/edit/{clasification}', 'AssetCategoryController@update');
    Route::delete('clasifications/delete/{clasification}', 'AssetCategoryController@destroy');
    
   
    
});
