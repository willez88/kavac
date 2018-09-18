<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Asset\Models\AssetUse;

/**
 * @class AssetUseTableSeeder
 * @brief Inicializar Funciones de uso de los bienes
 * 
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetUseTableSeeder extends Seeder
{
    /**
     * Método que registra los valores iniciales de las funciones de uso de un bien
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $asset_use = [
            ['name' => 'Residencial'],
            ['name' => 'Agrícola'],
            ['name' => 'Turístico'],
            ['name' => 'Comercial'],
            ['name' => 'Educativo'],
            ['name' => 'Asistencial'],
            ['name' => 'De oficina'],
            ['name' => 'Industrial'],
            ['name' => 'Otro Uso']

        ];


           
            foreach ($asset_use as $use) {
                AssetUse::updateOrCreate(
                    ['name' => $use['name']]
                );
            }
    }
}

