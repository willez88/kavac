<?php
/**
 * -----------------------------------------------------------------------
 * Grupo de rutas de acceso exclusivo del usuario administrador
 * -----------------------------------------------------------------------
 *
 * Gestiona las rutas que solo pueden accederse si el usuario autenticado
 * es administrador del sistema
 */
Route::group(['middleware' => ['auth', 'verified', 'role:admin']], function () {
    /**
     * ------------------------------------------------------------------
     * Grupo de rutas del namespace Admin
     * ------------------------------------------------------------------
     */
    Route::group(['namespace' => 'Admin'], function () {
        /** Ruta para la configuración de la aplicación */
        Route::resource('settings', 'SettingController', [
            'except' => ['create', 'edit', 'show', 'update', 'destroy']
        ]);
        /** Rutas para la gestión de módulos de la aplicación */
        Route::group(['prefix' => 'modules'], function () {
            Route::get('list', 'ModuleController@index')->name('module.list');
            Route::post('enable', 'ModuleController@enable')->name('module.enable');
            Route::post('disable', 'ModuleController@disable')->name('module.disable');
            Route::post('details', 'ModuleController@getDetails')->name('module.details');
        });
        /** Ruta para la gestión de información sobre la(s) institución(es) */
        Route::resource('institutions', 'InstitutionController', [
            'except' => ['create', 'show', 'edit', 'update', 'destroy']
        ]);

        /** Rutas para gestionar respaldos de la aplicación */
        Route::get('backup', 'BackupController@index')->name('backup.index');
        Route::get('backup/create', 'BackupController@create')->name('backup.create');
        Route::get('backup/download/{file_name}', 'BackupController@download')->name('backup.download');
        Route::get('backup/delete/{file_name}', 'BackupController@delete')->name('backup.delete');

        /** Obtiene las instituciones registradas */
        Route::get('get-institutions', 'InstitutionController@getInstitutions');
        Route::get(
            'get-institution/details/{institution}',
            'InstitutionController@getDetails'
        )->name('institution.details');

        /** Gestión de la aplicación */
        Route::group(['prefix' => 'app'], function () {
            /** Gestión de registros eliminados */
            Route::post('deleted-records', 'AppManagementController@getDeletedRecords');
            Route::post('restore-record', 'AppManagementController@restoreRecord');
            /** Gestión de auditoria de registros */
            Route::post('audit-records', 'AppManagementController@getAuditRecords');
            Route::post('audit-details', 'AppManagementController@getAuditDetails');
        });
    });

    /**
     * ------------------------------------------------------------------
     * Grupo de rutas del namespace Auth
     * ------------------------------------------------------------------
     */
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth'], function () {
        /** Rutas para la configuración de usuarios, roles y permisos */
        Route::get('settings/users', 'UserController@index')->name('access.settings.users');
        Route::get('settings/roles-permissions', 'UserController@indexRolesPermissions')->name('access.settings');

        Route::get('get-roles-permissions', 'UserController@getRolesAndPermissions')->name('get.roles.permissions');

        /** Ruta de configuración de permisos asociados a los distintos roles del sistema */
        Route::post('settings/roles-permissions', 'UserController@setRolesAndPermissions')
             ->name('roles.permissions.settings');

        /** Ruta para la assignación de roles y permisos a usuarios del sistema */
        Route::get('assign/roles-permissions/{user}', 'UserController@assignAccess')->name('assign.access');
        Route::post('assign/roles-permissions', 'UserController@setAccess')->name('roles.permissions.assign');
    });
});
