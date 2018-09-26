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
            ['slug' => 'Payroll'],
            ['name' => 'Nómina', 'description' => 'Coordinador de nómina']
        );

        $permissions = [
            [
                'name' => 'Configuración del módulo de nómina', 'slug' => 'payroll.setting.index',
                'description' => 'Acceso a la configuración del módulo de nómina',
                'model' => '', 'model_prefix' => 'nomina',
                'slug_alt' => 'configuracion.ver'
            ],
            [
                'name' => 'Ver tipos de personal', 'slug' => 'payroll.staff-type.index',
                'description' => 'Acceso para ver tipos de personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo_personal.ver'
            ],
            [
                'name' => 'Crear tipos de personal', 'slug' => 'payroll.staff-type.create',
                'description' => 'Acceso para crear tipos de personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo_personal.crear'
            ],
            [
                'name' => 'Editar tipos de personal', 'slug' => 'payroll.staff-type.edit',
                'description' => 'Acceso para editar los tipos de personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo_personal.editar'
            ],
            [
                'name' => 'Eliminar tipos de personal', 'slug' => 'payroll.staff-type.delete',
                'description' => 'Acceso para eliminar tipos de personal',
                'model' => 'Modules\Payroll\Models\PayrollStaffType', 'model_prefix' => 'nomina',
                'slug_alt' => 'tipo_personal.eliminar'
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
