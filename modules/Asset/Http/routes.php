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

Route::group(['middleware' => ['web','auth'], 'prefix' => 'asset', 'namespace' => 'Modules\Asset\Http\Controllers'], function()
{
    Route::get('settings', 'AssetSettingController@index')->name('asset.setting.index');

	/**
	 * Ruta para el Home de Bienes Institucionales 
	 */

    //Route::get('/', 'AssetSettingController@index');
    
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
     * Rutas para gestionar la generación de Solicitudes en pdf
     */

    Route::get('pdf', 'PDFController@create');


    /**
     * Rutas para gestionar la generación de Reportes
     */

    Route::get('report/{type}', 'AssetReportController@create')->name('asset.report.create');



    /**
     * Rutas para gestionar los Servicios del Modulo de Bienes Institucionales
     */

    Route::get('vue-list', 'ServiceController@vueListTypes')->name('asset.services.vuelist');
    Route::get('get-types', 'ServiceController@GetTypes')->name('asset.services.types');
    Route::get('get-categories/{type}', 'ServiceController@GetCategories')->name('asset.services.categories');
    Route::get('get-subcategories/{category}', 'ServiceController@GetSubcategories')->name('asset.services.subcategories');


    
   
    
});


/**
 * -----------------------------------------------------------------------
 * Grupo de rutas para la gestión de componentes vue
 * -----------------------------------------------------------------------
 *
 * Permite gestionar los distintos modelos de uso común en el modulo de bienes
 *  de la aplicación
 */

Route::group(['middleware' => ['web','auth'], 'namespace' => 'Modules\Asset\Http\Controllers'], function()
{
    /**
     * Rutas para gestionar los registros de bienes
     */
    Route::resource('asset', 'AssetController', ['except' => ['show']]);
    Route::get('asset/info/{asset}', 'AssetController@info');

    /**
     * Rutas para gestionar el clasificador de bienes
     */
    Route::resource('clasifications', 'AssetClasificationController', ['except' => ['show']]);

    /**
     * Rutas para gestionar los tipos de bienes
     */
    Route::resource('types', 'AssetTypeController', ['except' => ['show']]);
    
    /**
     * Rutas para gestionar las categorias de bienes
     */
    Route::resource('categories', 'AssetCategoryController', ['except' => ['show']]);

    /**
     * Rutas para gestionar las subcategorias de bienes
     */
    Route::resource('subcategories', 'AssetSubcategoryController', ['except' => ['show']]);

    /**
     * Rutas para gestionar las Categorias Especificas de bienes
     */
    Route::resource('specific', 'AssetSpecificCategoryController', ['except' => ['show']]);

});