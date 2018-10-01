<?php

namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;

class PayrollRoleAndPermissionsTableSeeder extends Seeder
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

        $payrollRole = Role::updateOrCreate(
            ['slug' => 'payroll'],
            ['name' => 'Nómina', 'description' => 'Coordinador de nómina']
        );

        $permissions = [
            [
                'name' => 'Configuración del módulo de nómina', 'slug' => 'payroll.setting.index',
                'description' => 'Acceso a la configuración del módulo de nómina',
                'model' => '', 'model_prefix' => 'nomina',
                'slug_alt' => 'configuracion.ver'
            ],
            // Staff Types
            [
                'name' => 'Ver tipos de personal', 'slug' => 'payroll.staff.types.index',
                'description' => 'Acceso para ver tipos de personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.personal.ver'
            ],
            [
                'name' => 'Crear tipos de personal', 'slug' => 'payroll.staff.types.create',
                'description' => 'Acceso para crear tipos de personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.personal.crear'
            ],
            [
                'name' => 'Editar tipos de personal', 'slug' => 'payroll.staff.types.edit',
                'description' => 'Acceso para editar los tipos de personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.personal.editar'
            ],
            [
                'name' => 'Eliminar tipos de personal', 'slug' => 'payroll.staff.types.delete',
                'description' => 'Acceso para eliminar tipos de personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.personal.eliminar'
            ],
            // Position Types
            [
                'name' => 'Ver tipos de cargo', 'slug' => 'payroll.position.types.index',
                'description' => 'Acceso para ver tipos de cargo',
                'model' => 'Modules\Payroll\Models\PayrollPositionType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.cargo.ver'
            ],
            [
                'name' => 'Crear tipos de cargo', 'slug' => 'payroll.position.types.create',
                'description' => 'Acceso para crear tipos de cargo',
                'model' => 'Modules\Payroll\Models\PayrollPositionType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.cargo.crear'
            ],
            [
                'name' => 'Editar tipos de cargo', 'slug' => 'payroll.position.types.edit',
                'description' => 'Acceso para editar los tipos de cargo',
                'model' => 'Modules\Payroll\Models\PayrollPositionType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.cargo.editar'
            ],
            [
                'name' => 'Eliminar tipos de cargo', 'slug' => 'payroll.position.types.delete',
                'description' => 'Acceso para eliminar tipos de cargo',
                'model' => 'Modules\Payroll\Models\PayrollPositionType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo.cargo.eliminar'
            ],
            // Positions
            [
                'name' => 'Ver cargos', 'slug' => 'payroll.positions.index',
                'description' => 'Acceso para ver los cargos',
                'model' => 'Modules\Payroll\Models\PayrollPosition', 'model_prefix' => 'nomina',
                'slug_alt' => 'cargo.ver'
            ],
            [
                'name' => 'Crear cargos', 'slug' => 'payroll.positions.create',
                'description' => 'Acceso para crear cargos',
                'model' => 'Modules\Payroll\Models\PayrollPosition', 'model_prefix' => 'nomina',
                'slug_alt' => 'cargo.crear'
            ],
            [
                'name' => 'Editar cargos', 'slug' => 'payroll.positions.edit',
                'description' => 'Acceso para editar los cargos',
                'model' => 'Modules\Payroll\Models\PayrollPosition', 'model_prefix' => 'nomina',
                'slug_alt' => 'cargo.editar'
            ],
            [
                'name' => 'Eliminar cargos', 'slug' => 'payroll.positions.delete',
                'description' => 'Acceso para eliminar cargos',
                'model' => 'Modules\Payroll\Models\PayrollPosition', 'model_prefix' => 'nomina',
                'slug_alt' => 'cargo.eliminar'
            ],
        ];

        foreach ($permissions as $permission) {
            $per = Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'], 'description' => $permission['description'],
                    'model' => $permission['model'], 'model_prefix' => $permission['model_prefix'],
                    'slug_alt' => $permission['slug_alt']
                ]
            );

            $payrollRole->attachPermission($per);

            if ($adminRole) {
                $adminRole->attachPermission($per);
            }
        }
    }
}
