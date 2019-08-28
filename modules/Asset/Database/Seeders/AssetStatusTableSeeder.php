<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Asset\Models\AssetStatus;

/**
 * @class AssetStatusTableSeeder
 * @brief Inicializar los Estados de uso de los bienes
 *
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetStatusTableSeeder extends Seeder
{
    /**
     * Método que registra los valores iniciales de las formas de la condición física de un bien
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $asset_status = [
            ['name' => 'En Uso'],
            ['name' => 'En Comodato'],
            ['name' => 'En Arrendamiento'],
            ['name' => 'En Mantenimiento'],
            ['name' => 'En Reparación'],
            ['name' => 'En Proceso de Disposición'],
            ['name' => 'En Desuso por Obsolescencia'],
            ['name' => 'En Desuso por Inservibilidad'],
            ['name' => 'En Desuso por Obsolescencia e Inservilidad'],
            ['name' => 'En almacen o Depósito para su Asignación']

        ];


           
        foreach ($asset_status as $status) {
            AssetStatus::updateOrCreate(
                ['name' => $status['name']]
            );
        }
    }
}
