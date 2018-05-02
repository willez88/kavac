<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;

class BudgetRoleAndPermissionsTableSeeder extends Seeder
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

        $budgetRole = Role::updateOrCreate(
            ['slug' => 'Budget'],
            ['name' => 'Presupuesto', 'description' => 'Coordinador de presupuesto']
        );

        $permissions = [
            [
                'name' => 'Inicio del módulo de presupuesto', 'slug' => 'budget.home',
                'description' => 'Acceso a descripción del módulo de presupuesto', 
                'model' => 'Modules\Budget\Models\BudgetAccount', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'presupuesto.inicio'
            ],
            [
                'name' => 'Configuración del módulo de presupuesto', 'slug' => 'budget.setting.create',
                'description' => 'Acceso a la configuración del módulo de presupuesto', 
                'model' => '', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'configuracion.crear'
            ],
            [
                'name' => 'Editar configuración del módulo de presupuesto', 
                'slug' => 'budget.setting.edit',
                'description' => 'Acceso para editar la configuración del módulo de presupuesto', 
                'model' => '', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'configuracion.editar'
            ],
            [
                'name' => 'Ver configuración del módulo de presupuesto', 
                'slug' => 'budget.setting.list',
                'description' => 'Acceso para editar la configuración del módulo de presupuesto', 
                'model' => '', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'configuracion.ver'
            ],
            [
                'name' => 'Eliminar configuración del módulo de presupuesto', 
                'slug' => 'budget.setting.delete',
                'description' => 'Acceso para eliminar la configuración del módulo de presupuesto', 
                'model' => '', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'configuracion.eliminar'
            ],
            [
                'name' => 'Crear cuenta presupuestaria', 'slug' => 'budget.account.create',
                'description' => 'Acceso para crear cuenta presupuestaria', 
                'model' => 'Modules\Budget\Models\BudgetAccount', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'clasificador.crear'
            ],
            [
                'name' => 'Editar cuenta presupuestaria', 'slug' => 'budget.account.edit',
                'description' => 'Acceso para editar cuenta presupuestaria', 
                'model' => 'Modules\Budget\Models\BudgetAccount', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'clasificador.editar'
            ],
            [
                'name' => 'Eliminar cuenta presupuestaria', 'slug' => 'budget.account.delete',
                'description' => 'Acceso para eliminar cuenta presupuestaria', 
                'model' => 'Modules\Budget\Models\BudgetAccount', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'clasificador.eliminar'
            ],
            [
                'name' => 'Ver cuentas presupuestarias', 'slug' => 'budget.account.list',
                'description' => 'Acceso para ver cuentas presupuestarias', 
                'model' => 'Modules\Budget\Models\BudgetAccount', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'clasificador.ver'
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

            $budgetRole->attachPermission($per);

            if ($adminRole) {
                $adminRole->attachPermission($per);
            }
        }

    }
}
