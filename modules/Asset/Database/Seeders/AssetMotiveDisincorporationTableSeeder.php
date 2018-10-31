<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Asset\Models\AssetMotiveDisincorporation;

/**
 * @class AssetMotiveDisincorporation
 * @brief Inicializar los Motivos de desincorporación de los bienes
 * 
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetMotiveDisincorporationTableSeeder extends Seeder
{
    /**
     * Método que registra los valores iniciales de las formas de la condición física de un bien
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $motive_disincorporation = [
            ['name' => 'En Desuso por Obsolescencia'],
            ['name' => 'En Desuso por Inservibilidad'],
            ['name' => 'En Desuso por Obsolescencia e Inservilidad'],
            ['name' => 'En Desuso por Reparación'],
            ['name' => 'En Desuso por Reparación Antieconómica'],
            ['name' => 'En Desuso por Perdida'],
            ['name' => 'Venta'],
            ['name' => 'Donación'],

        ];


           
            foreach ($motive_disincorporation as $status) {
                AssetMotiveDisincorporation::updateOrCreate(
                    ['name' => $status['name']]
                );
            }
    }
}
