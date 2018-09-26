<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class BudgetDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        /** Seeder para clasificador presupuestario original */
        $this->call(BudgetAccountsTableSeeder::class);
        /** Seeder para roles y permisos disponibles en el módulo */
        $this->call(BudgetRoleAndPermissionsTableSeeder::class);
    }
}
