<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * @class BudgetDatabaseSeeder
 * @brief Información por defecto para datos iniciales del módulo de presupuesto
 * 
 * Gestiona la información por defecto a registrar inicialmente para los datos iniciales del módulo de presupuesto
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
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
