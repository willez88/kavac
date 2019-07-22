<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * @class AssetDatabaseSeeder
 * @brief Inicializa el Modulo de Bienes
 * 
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AssetDatabaseSeeder extends Seeder
{
    /**
     * Método que realiza el llamado a los seeders del modulo de bienes
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AssetRoleAndPermissionsTableSeeder::class);

        $this->call(AssetTypesTableSeeder::class);
        $this->call(AssetCategoriesTableSeeder::class);
        $this->call(AssetSubcategoriesTableSeeder::class);
        $this->call(AssetSpecificCategoriesTableSeeder::class);
        $this->call(AssetAcquisitionTypesTableSeeder::class);
        $this->call(AssetConditionsTableSeeder::class);
        $this->call(AssetStatusTableSeeder::class);
        $this->call(AssetUseFunctionsTableSeeder::class);
        $this->call(AssetDisincorporationMotivesTableSeeder::class);
    }
}
