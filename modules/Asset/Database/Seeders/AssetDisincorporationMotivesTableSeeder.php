<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Asset\Models\AssetDisincorporationMotive;

/**
 * @class AssetDisincorporationMotivesTableSeeder
 * @brief Inicializar los Motivos de desincorporación de los bienes
 *
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetDisincorporationMotivesTableSeeder extends Seeder
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

        $disincorporation_motives = [
            ['name' => 'En Desuso por Obsolescencia'],
            ['name' => 'En Desuso por Inservibilidad'],
            ['name' => 'En Desuso por Obsolescencia e Inservilidad'],
            ['name' => 'En Desuso por Reparación'],
            ['name' => 'En Desuso por Reparación Antieconómica'],
            ['name' => 'En Desuso por Perdida'],
            ['name' => 'Venta'],
            ['name' => 'Donación'],

        ];


           
        foreach ($disincorporation_motives as $disincorporation_motive) {
            AssetDisincorporationMotive::updateOrCreate(
                ['name' => $disincorporation_motive['name']]
            );
        }
    }
}
