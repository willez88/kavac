<?php

namespace Modules\Purchase\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * @class PurchaseDatabaseSeeder
 * @brief Información por defecto para datos iniciales del módulo de compra
 * 
 * Gestiona la información por defecto a registrar inicialmente para los datos iniciales del módulo de compra
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PurchaseDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(PurchaseRoleAndPermissionsTableSeeder::class);
        $this->call(PurchaseSupplierObjectsTableSeeder::class);
        $this->call(PurchaseSupplierBranchesTableSeeder::class);
        $this->call(PurchaseSupplierSpecialtiesTableSeeder::class);
        $this->call(PurchaseSupplierTypesTableSeeder::class);
    }
}
