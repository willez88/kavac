<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * @class AssetDatabaseSeeder
 * @brief Inicializa el módulo de bienes
 *
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
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
        /** Roles disponibles para el acceso al módulo de bienes */
        $this->call(AssetRoleAndPermissionsTableSeeder::class);

        /** Registros de tipos de bienes */
        $this->call(AssetTypesTableSeeder::class);

        /** Registros de categorias de bienes */
        $this->call(AssetCategoriesTableSeeder::class);

        /** Registros de subcategorias de bienes */
        $this->call(AssetSubcategoriesTableSeeder::class);

        /** Registros de categorias específicas de bienes */
        $this->call(AssetSpecificCategoriesTableSeeder::class);

        /** Registros de tipos de adquisición de bienes */
        $this->call(AssetAcquisitionTypesTableSeeder::class);

        /** Registros de condiciones físicas de bienes */
        $this->call(AssetConditionsTableSeeder::class);

        /** Registros de estatus de uso de bienes */
        $this->call(AssetStatusTableSeeder::class);

        /** Registros de funciones de uso de bienes */
        $this->call(AssetUseFunctionsTableSeeder::class);
        
        /** Registros de motivos de desincorporación de bienes */
        $this->call(AssetDisincorporationMotivesTableSeeder::class);
    }
}
