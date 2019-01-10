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
                'model' => 'Modules\Budget\Models\BudgetProject', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'proyecto.crear', 'short_description' => 'agregar proyecto'
            ],
            [
                'name' => 'Editar proyecto', 'slug' => 'budget.project.edit',
                'description' => 'Acceso para editar proyectos', 
                'model' => 'Modules\Budget\Models\BudgetProject', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'proyecto.editar', 'short_description' => 'editar proyecto'
            ],
            [
                'name' => 'Eliminar proyecto', 'slug' => 'budget.project.delete',
                'description' => 'Acceso para eliminar proyectos', 
                'model' => 'Modules\Budget\Models\BudgetProject', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'proyecto.eliminar', 'short_description' => 'eliminar proyecto'
            ],
            [
                'name' => 'Ver proyectos', 'slug' => 'budget.project.list',
                'description' => 'Acceso para ver proyectos', 
                'model' => 'Modules\Budget\Models\BudgetProject', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'proyecto.ver', 'short_description' => 'ver proyecto'
            ],

            [
                'name' => 'Crear acción centralizada', 'slug' => 'budget.centralizedaction.create',
                'description' => 'Acceso para crear acción centralizada', 
                'model' => 'Modules\Budget\Models\BudgetCentralizedAction', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'accion_centralizada.crear', 'short_description' => 'agregar acción centralizada'
            ],
            [
                'name' => 'Editar acción centralizada', 'slug' => 'budget.centralizedaction.edit',
                'description' => 'Acceso para editar acción centralizada', 
                'model' => 'Modules\Budget\Models\BudgetCentralizedAction', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'accion_centralizada.editar', 'short_description' => 'editar acción centralizada'
            ],
            [
                'name' => 'Eliminar acción centralizada', 'slug' => 'budget.centralizedaction.delete',
                'description' => 'Acceso para eliminar acción centralizada', 
                'model' => 'Modules\Budget\Models\BudgetCentralizedAction', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'accion_centralizada.eliminar', 'short_description' => 'eliminar acción centralizada'
            ],
            [
                'name' => 'Ver acciones centralizadas', 'slug' => 'budget.centralizedaction.list',
                'description' => 'Acceso para ver acciones centralizadas', 
                'model' => 'Modules\Budget\Models\BudgetCentralizedAction', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'accion_centralizada.ver', 'short_description' => 'ver acción centralizada'
            ],
            [
                'name' => 'Crear acción específica', 'slug' => 'budget.specificaction.create',
                'description' => 'Acceso para crear acción específica', 
                'model' => 'Modules\Budget\Models\BudgetSpecificAction', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'accion_especifica.crear', 'short_description' => 'agregar acción específica'
            ],
            [
                'name' => 'Editar acción específica', 'slug' => 'budget.specificaction.edit',
                'description' => 'Acceso para editar acciones específicas', 
                'model' => 'Modules\Budget\Models\BudgetSpecificAction', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'accion_especifica.editar', 'short_description' => 'editar acción específica'
            ],
            [
                'name' => 'Eliminar acción específica', 'slug' => 'budget.specificaction.delete',
                'description' => 'Acceso para eliminar acciones específicas', 
                'model' => 'Modules\Budget\Models\BudgetSpecificAction', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'accion_especifica.eliminar', 'short_description' => 'eliminar acción específica'
            ],
            [
                'name' => 'Ver acciones específicas', 'slug' => 'budget.specificaction.list',
                'description' => 'Acceso para ver acciones específicas', 
                'model' => 'Modules\Budget\Models\BudgetSpecificAction', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'accion_especifica.ver', 'short_description' => 'ver acción específica'
            ],
            [
                'name' => 'Crear formulación de presupuesto', 'slug' => 'budget.formulation.create',
                'description' => 'Acceso para crear formulación de presupuesto', 
                'model' => 'Modules\Budget\Models\BudgetFormulation', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'formulacion.crear', 'short_description' => 'agregar formulación'
            ],
            [
                'name' => 'Editar formulación de presupuesto', 'slug' => 'budget.formulation.edit',
                'description' => 'Acceso para editar formulaciones de presupuesto', 
                'model' => 'Modules\Budget\Models\BudgetFormulation', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'formulacion.editar', 'short_description' => 'editar formulación'
            ],
            [
                'name' => 'Eliminar formulación de presupuesto', 'slug' => 'budget.formulation.delete',
                'description' => 'Acceso para eliminar formulaciones de presupuesto', 
                'model' => 'Modules\Budget\Models\BudgetFormulation', 'model_prefix' => 'presupuesto',
                'slug_alt' => 'formulacion.eliminar', 'short_description' => 'eliminar formulación'
            ],
            [
                'name' => 'Ver formulaciones de presupuesto', 'slug' => 'budget.formulation.list',
                'description' => 'Acceso para ver formulaciones de presupuesto', 
                'model' => 'Modules\Budget\Models\BudgetFormulation', 'model_prefix' => 'presupuesto',
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
