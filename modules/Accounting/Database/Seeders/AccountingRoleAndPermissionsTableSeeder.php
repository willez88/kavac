<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Roles\Models\Role;
use App\Roles\Models\Permission;

/**
 * @class AccountingRoleAndPermissionsTableSeeder
 * @brief Información por defecto para Roles y Permisos del módulo de contabilidad
 *
 * Gestiona la información por defecto a registrar inicialmente para los Roles y Permisos del módulo de contabilidad
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingRoleAndPermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $adminRole = Role::where('slug', 'admin')->first();

        $accountingRole = Role::updateOrCreate(
            ['slug' => 'account'],
            ['name' => 'Contabilidad', 'description' => 'Coordinador de cuentas Contables']
        );

        $permissions = [

            /**
            * cuentas patrimoniales
            */
            [
                'name' => 'Ver cuentas patrimoniales', 'slug' => 'accounting.account.list',
                'description' => 'Acceso para ver cuentas patrimoniales',
                'model' => 'Modules\Accounting\Models\AccountingAccount', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'cuentas_patrimoniales.ver', 'short_description' => 'listar cuentas patrimoniales'
            ],
            [
                'name' => 'Crear cuenta patrimonial', 'slug' => 'accounting.account.create',
                'description' => 'Acceso para crear cuenta patrimonial',
                'model' => 'Modules\Accounting\Models\AccountingAccount', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'cuentas_patrimoniales.crear', 'short_description' => 'agregar cuentas patrimoniales'
            ],
            [
                'name' => 'Editar cuenta patrimonial', 'slug' => 'accounting.account.edit',
                'description' => 'Acceso para editar cuenta patrimonial',
                'model' => 'Modules\Accounting\Models\AccountingAccount', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'cuentas_patrimoniales.editar', 'short_description' => 'editar cuentas patrimoniales'
            ],
            [
                'name' => 'Eliminar cuenta patrimonial', 'slug' => 'accounting.account.delete',
                'description' => 'Acceso para eliminar cuenta patrimonial',
                'model' => 'Modules\Accounting\Models\AccountingAccount', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'cuentas_patrimoniales.eliminar', 'short_description' => 'eliminar cuentas patrimoniales'
            ],

            /**
            * Convertidor de cuentas
            */
            [
                'name' => 'vista principal de consulta del convertidor de cuentas', 'slug' => 'accounting.converter.index',
                'description' => 'Acceso para listar conversiones',
                'model' => 'Modules\Accounting\Models\AccountingAccountConverter', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'conversion.ver', 'short_description' => 'listar conversion'
            ],
            [
                'name' => 'Crear nueva conversión', 'slug' => 'accounting.converter.create',
                'description' => 'Acceso para crear nuevas conversiones',
                'model' => 'Modules\Accounting\Models\AccountingAccountConverter', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'conversion.crear', 'short_description' => 'agregar conversion'
            ],
            [
                'name' => 'Editar conversiones', 'slug' => 'accounting.converter.edit',
                'description' => 'Acceso para editar registro conversiones',
                'model' => 'Modules\Accounting\Models\AccountingAccountConverter', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'conversion.editar', 'short_description' => 'editar conversion'
            ],
            [
                'name' => 'Eliminar conversión', 'slug' => 'accounting.converter.delete',
                'description' => 'Acceso para eliminar registro de conversiones',
                'model' => 'Modules\Accounting\Models\AccountingAccountConverter', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'conversion.eliminar', 'short_description' => 'eliminar conversion'
            ],

            /**
            * Asientos Contables
            */
            [
                'name' => 'listar asientos contables aprobados y no aprobados', 'slug' => 'accounting.entries.list',
                'description' => 'Acceso para listar asientos contable',
                'model' => 'Modules\Accounting\Models\AccountingSeat', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'asiento_contable.ver', 'short_description' => 'listar asientos contables'
            ],
            [
                'name' => 'Crear asiento contable', 'slug' => 'accounting.entries.create',
                'description' => 'Acceso para crear asiento contable',
                'model' => 'Modules\Accounting\Models\AccountingSeat', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'asiento_contable.crear', 'short_description' => 'crear asientos contables'
            ],
            [
                'name' => 'Editar asientos contables', 'slug' => 'accounting.entries.edit',
                'description' => 'Acceso para editar registro de asientos contables',
                'model' => 'Modules\Accounting\Models\AccountingSeat', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'asiento_contable.editar', 'short_description' => 'editar asientos contables'
            ],
            [
                'name' => 'Eliminar asientos contables', 'slug' => 'accounting.entries.delete',
                'description' => 'Acceso para eliminar asiento contable',
                'model' => 'Modules\Accounting\Models\AccountingSeat', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'asiento_contable.eliminar', 'short_description' => 'eliminar asiento contable'
            ],
            [
                'name' => 'Aprobar asientos contables', 'slug' => 'accounting.entries.approve',
                'description' => 'Acceso para aprobar asiento contable',
                'model' => 'Modules\Accounting\Models\AccountingSeat', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'asiento_contable.approve', 'short_description' => 'aprobar asiento contable'
            ],
            [
                'name' => 'reporte pdf de asientos contables', 'slug' => 'accounting.entries.report',
                'description' => 'Acceso para generar reporte pdf de asiento contable',
                'model' => 'Modules\Accounting\Models\AccountingSeat', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'asiento_contable.pdf', 'short_description' => 'reporte pdf de asiento contable'
            ],

            /**
            * Configuración del modulo
            */
            [
                'name' => 'vista principal de la configuración', 'slug' => 'accounting.setting.index',
                'description' => 'Acceso para visualizar las configuraciones del modulo',
                'model' => '', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'configuracion.ver', 'short_description' => 'Visualizar configuraciones'
            ],
            [
                'name' => 'Crear nueva categoria', 'slug' => 'accounting.setting.category.store',
                'description' => 'Acceso para guardar nueva categoria',
                'model' => 'Modules\Accounting\Models\AccountingSeatCategory', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'configuracion_categoria.guardar', 'short_description' => 'guardar categoria'
            ],
            [
                'name' => 'Actualizar categoria', 'slug' => 'accounting.setting.category.update',
                'description' => 'Acceso para actualizar categoria',
                'model' => 'Modules\Accounting\Models\AccountingSeatCategory', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'configuracion_categoria.actualizar', 'short_description' => 'actualizar categoria'
            ],
            [
                'name' => 'Eliminar categoria', 'slug' => 'accounting.setting.category.delete',
                'description' => 'Acceso para eliminar categoria',
                'model' => 'Modules\Accounting\Models\AccountingSeatCategory', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'configuracion_categoria.eliminar', 'short_description' => 'eliminar categoria'
            ],

            /**
            * Reportes Generales
            */
            [
                'name' => 'Vista principal para los reportes de libros contables', 'slug' => 'accounting.report.accountingbooks',
                'description' => 'Acceso a la vista principal de reportes de los libros contables',
                'model' => '', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'vista_principal_reportes_libros_contables', 'short_description' => 'acceso a la vista principal de reportes de libros contables'
            ],
            [
                'name' => 'Vista principal para los reportes de estados financieros', 'slug' => 'accounting.report.financestatements',
                'description' => 'Acceso a la vista principal de reportes de estados financieros',
                'model' => '', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'vista_principal_reportes_estados_financieros', 'short_description' => 'acceso a la vista principal de reportes de estados financieros'
            ],

            [
                'name' => 'reporte pdf de libro diario', 'slug' => 'accounting.report.dailybook',
                'description' => 'Acceso para generar reporte pdf de libro diario',
                'model' => '', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'reporte_libro_diario.pdf', 'short_description' => 'reporte pdf de libro diario'
            ],
            [
                'name' => 'reporte pdf balance de comprobación', 'slug' => 'accounting.report.checkupbalance',
                'description' => 'Acceso para generar reporte pdf balance de comprobación',
                'model' => '', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'reporte_balance_comprobación.pdf', 'short_description' => 'reporte pdf balance de comprobación'
            ],
            [
                'name' => 'reporte pdf de Mayor analítico', 'slug' => 'accounting.report.analiticalmajor',
                'description' => 'Acceso para generar reporte pdf de Mayor analítico',
                'model' => '', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'reporte_mayor_analítico.pdf', 'short_description' => 'reporte pdf de Mayor analítico'
            ],
            [
                'name' => 'reporte pdf de Libro Auxiliar', 'slug' => 'accounting.report.auxiliarybook',
                'description' => 'Acceso para generar reporte pdf de Libro Auxiliar',
                'model' => '', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'reporte_libro_auxiliar.pdf', 'short_description' => 'reporte pdf de Libro Auxiliar'
            ],
            [
                'name' => 'reporte pdf de Balance General', 'slug' => 'accounting.report.balancesheet',
                'description' => 'Acceso para generar reporte pdf de Balance General',
                'model' => '', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'reporte_balance_general.pdf', 'short_description' => 'reporte pdf de Balance General'
            ],
            [
                'name' => 'reporte pdf de Estado de Resultados', 'slug' => 'accounting.report.stateofresults',
                'description' => 'Acceso para generar reporte pdf de Estado de Resultados',
                'model' => '', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'reporte_estados_de_resultados.pdf', 'short_description' => 'reporte pdf de Estado de Resultados'
            ],

            /**
            * Dashboard
            */
            [
                'name' => 'vista principal del dashboard del módulo de contabilidad', 'slug' => 'accounting.dashboard',
                'description' => 'Acceso para visualizar el dashboard del módulo',
                'model' => '', 'model_prefix' => 'contabilidad',
                'slug_alt' => 'panel_de_control.ver', 'short_description' => 'Visualizar panel de control del módulo de contabilidad'
            ],
        ];

        $accountingRole->detachAllPermissions();

        foreach ($permissions as $permission) {
            $per = Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'], 'description' => $permission['description'],
                    'model' => $permission['model'], 'model_prefix' => $permission['model_prefix'],
                    'slug_alt' => $permission['slug_alt'], 'short_description' => $permission['short_description']
                ]
            );

            $accountingRole->attachPermission($per);

            if ($adminRole) {
                $adminRole->attachPermission($per);
            }
        }
    }
}
