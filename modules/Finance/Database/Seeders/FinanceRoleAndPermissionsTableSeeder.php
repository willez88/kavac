<?php

namespace Modules\Finance\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Ultraware\Roles\Models\Role;
use Ultraware\Roles\Models\Permission;

class FinanceRoleAndPermissionsTableSeeder extends Seeder
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

        $financeRole = Role::updateOrCreate(
            ['slug' => 'finance'],
            ['name' => 'Finanza', 'description' => 'Coordinador de finanza']
        );

        $permissions = [
            [
                'name' => 'Configuración en módulo de finanza', 'slug' => 'finance.setting.create',
                'description' => 'Acceso a la configuración del módulo de finanza', 
                'model' => 'Modules\Budget\Models\BudgetAccount', 'model_prefix' => 'finanza',
                'slug_alt' => 'finanza.configuracion.crear', 'short_description' => 'página de configuración'
            ],
        ];

        $financeRole->detachAllPermissions();

        foreach ($permissions as $permission) {
            $per = Permission::updateOrCreate(
                ['slug' => $permission['slug']],
                [
                    'name' => $permission['name'], 'description' => $permission['description'],
                    'model' => $permission['model'], 'model_prefix' => $permission['model_prefix'],
                    'slug_alt' => $permission['slug_alt'], 'short_description' => $permission['short_description']
                ]
            );

            $financeRole->attachPermission($per);

            if ($adminRole) {
                $adminRole->attachPermission($per);
            }
        }
    }
}
