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
            ['slug' => 'budget'],
            ['name' => 'Presupuesto', 'description' => 'Coordinador de presupuesto']
        );

        $permissions = [
            [
                'name' => 'Inicio del módulo de presupuesto', 'slug' => 'budget.home',
                'description' => 'Acceso a descripción del módulo de presupuesto', 
                'model' => 'Modules\Budget\Models\BudgetAccount', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'presupuesto.inicio', 'short_description' => 'página de inicio'
            ],
            [
                'name' => 'Configuración del módulo de presupuesto', 'slug' => 'budget.setting.create',
                'description' => 'Acceso a la configuración del módulo de presupuesto', 
                'model' => '', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'configuracion.crear', 'short_description' => 'agregar configuración'
            ],
            [
                'name' => 'Editar configuración del módulo de presupuesto', 
                'slug' => 'budget.setting.edit',
                'description' => 'Acceso para editar la configuración del módulo de presupuesto', 
                'model' => '', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'configuracion.editar', 'short_description' => 'editar configuración'
            ],
            [
                'name' => 'Ver configuración del módulo de presupuesto', 
                'slug' => 'budget.setting.list',
                'description' => 'Acceso para editar la configuración del módulo de presupuesto', 
                'model' => '', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'configuracion.ver', 'short_description' => 'ver configuración'
            ],
            [
                'name' => 'Eliminar configuración del módulo de presupuesto', 
                'slug' => 'budget.setting.delete',
                'description' => 'Acceso para eliminar la configuración del módulo de presupuesto', 
                'model' => '', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'configuracion.eliminar', 'short_description' => 'eliminar configuración'
            ],
            [
                'name' => 'Crear cuenta presupuestaria', 'slug' => 'budget.account.create',
                'description' => 'Acceso para crear cuenta presupuestaria', 
                'model' => 'Modules\Budget\Models\BudgetAccount', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'clasificador.crear', 'short_description' => 'agregar clasificador'
            ],
            [
                'name' => 'Editar cuenta presupuestaria', 'slug' => 'budget.account.edit',
                'description' => 'Acceso para editar cuenta presupuestaria', 
                'model' => 'Modules\Budget\Models\BudgetAccount', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'clasificador.editar', 'short_description' => 'editar clasificador'
            ],
            [
                'name' => 'Eliminar cuenta presupuestaria', 'slug' => 'budget.account.delete',
                'description' => 'Acceso para eliminar cuenta presupuestaria', 
                'model' => 'Modules\Budget\Models\BudgetAccount', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'clasificador.eliminar', 'short_description' => 'eliminar clasificador'
            ],
            [
                'name' => 'Ver cuentas presupuestarias', 'slug' => 'budget.account.list',
                'description' => 'Acceso para ver cuentas presupuestarias', 
                'model' => 'Modules\Budget\Models\BudgetAccount', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'clasificador.ver', 'short_description' => 'ver clasificador'
            ],
            [
                'name' => 'Crear proyecto', 'slug' => 'budget.project.create',
                'description' => 'Acceso para crear proyecto', 
                'model' => 'Modules\Budget\Models\BudgetProject', 'model_prefix' => 'proyecto',
                'slug_alt' => 'proyecto.crear', 'short_description' => 'agregar proyecto'
            ],
            [
                'name' => 'Editar cuenta presupuestaria', 'slug' => 'budget.project.edit',
                'description' => 'Acceso para editar cuenta presupuestaria', 
                'model' => 'Modules\Budget\Models\BudgetProject', 'model_prefix' => 'proyecto',
                'slug_alt' => 'proyecto.editar', 'short_description' => 'editar proyecto'
            ],
            [
                'name' => 'Eliminar cuenta presupuestaria', 'slug' => 'budget.project.delete',
                'description' => 'Acceso para eliminar cuenta presupuestaria', 
                'model' => 'Modules\Budget\Models\BudgetProject', 'model_prefix' => 'proyecto',
                'slug_alt' => 'proyecto.eliminar', 'short_description' => 'eliminar proyecto'
            ],
            [
                'name' => 'Ver cuentas presupuestarias', 'slug' => 'budget.project.list',
                'description' => 'Acceso para ver cuentas presupuestarias', 
                'model' => 'Modules\Budget\Models\BudgetProject', 'model_prefix' => 'proyecto',
                'slug_alt' => 'proyecto.ver', 'short_description' => 'ver proyecto'
            ],
            [
                'name' => 'Crear formulación de presupuesto', 'slug' => 'budget.formulation.create',
                'description' => 'Acceso para crear formulación de presupuesto', 
                'model' => 'Modules\Budget\Models\BudgetFormulation', 'model_prefix' => 'formulacion',
                'slug_alt' => 'formulacion.crear', 'short_description' => 'agregar formulación'
            ],
            [
                'name' => 'Editar cuenta presupuestaria', 'slug' => 'budget.formulation.edit',
                'description' => 'Acceso para editar cuenta presupuestaria', 
                'model' => 'Modules\Budget\Models\BudgetFormulation', 'model_prefix' => 'formulacion',
                'slug_alt' => 'formulacion.editar', 'short_description' => 'editar formulación'
            ],
            [
                'name' => 'Eliminar cuenta presupuestaria', 'slug' => 'budget.formulation.delete',
                'description' => 'Acceso para eliminar cuenta presupuestaria', 
                'model' => 'Modules\Budget\Models\BudgetFormulation', 'model_prefix' => 'formulacion',
                'slug_alt' => 'formulacion.eliminar', 'short_description' => 'eliminar formulación'
            ],
            [
                'name' => 'Ver cuentas presupuestarias', 'slug' => 'budget.formulation.list',
                'description' => 'Acceso para ver cuentas presupuestarias', 
                'model' => 'Modules\Budget\Models\BudgetFormulation', 'model_prefix' => 'formulacion',
                'slug_alt' => 'formulacion.ver', 'short_description' => 'ver formulación'
            ],
        ];

        $budgetRole->detachAllPermissions();

        foreach ($permissions as $permission) {
            $per = Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'], 'description' => $permission['description'],
                    'model' => $permission['model'], 'model_prefix' => $permission['model_prefix'],
                    'slug_alt' => $permission['slug_alt'], 'short_description' => $permission['short_description']
                ]
            );

            $budgetRole->attachPermission($per);

            if ($adminRole) {
                $adminRole->attachPermission($per);
            }
        }

    }
}
