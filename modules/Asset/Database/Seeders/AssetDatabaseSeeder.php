<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * @class AssetDatabaseSeeder
 * @brief Inicializa el Modulo de Bienes
 * 
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AssetDatabaseSeeder extends Seeder
{
    /**
     * Método que realiza el llamado a los seeders del modulo de bienes
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AssetRoleAndPermissionsTableSeeder::class);

        $this->call(AssetTypeTableSeeder::class);
        $this->call(AssetCategoryTableSeeder::class);
        $this->call(AssetSubcategoryTableSeeder::class);
        $this->call(AssetSpecificCategoryTableSeeder::class);
        $this->call(AssetPurchaseTableSeeder::class);
        $this->call(AssetConditionTableSeeder::class);
        $this->call(AssetStatusTableSeeder::class);
        $this->call(AssetUseTableSeeder::class);
    }
}
