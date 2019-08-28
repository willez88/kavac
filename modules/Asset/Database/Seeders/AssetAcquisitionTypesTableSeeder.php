<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Asset\Models\AssetAcquisitionType;

/**
 * @class AssetAcquisitionTypesTableSeeder
 * @brief Inicializar los tipos de adquisición de un bien
 *
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetAcquisitionTypesTableSeeder extends Seeder
{
    /**
     * Método que registra los valores iniciales de las formas de adquisición de un bien
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $asset_acquisition_types = [
            ['name' => 'Compra Directa (Consulta de Precio)'],
            ['name' => 'Permuta'],
            ['name' => 'Dación en Pago'],
            ['name' => 'Donación'],
            ['name' => 'Transferencia'],
            ['name' => 'Expropiación'],
            ['name' => 'Confiscación'],
            ['name' => 'Compra por Concurso Abierto'],
            ['name' => 'Compra por Concurso Cerrado'],
            ['name' => 'Adjudicación']
            
        ];


           
        foreach ($asset_acquisition_types as $asset_acquisition_type) {
            AssetAcquisitionType::updateOrCreate(
                ['name' => $asset_acquisition_type['name']]
            );
        }
    }
}
