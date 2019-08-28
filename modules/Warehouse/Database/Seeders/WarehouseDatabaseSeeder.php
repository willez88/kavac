<?php

namespace Modules\Warehouse\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * @class WarehouseDatabaseSeeder
 * @brief Inicializa el módulo de almacén
 *
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseDatabaseSeeder extends Seeder
{
    /**
     * Método que realiza el llamado a los seeders del módulo de almacén
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function run()
    {
        /** Roles disponibles para el acceso al módulo de almacén */
        $this->call(WarehouseRoleAndPermissionsTableSeeder::class);
    }
}
