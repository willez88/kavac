<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Asset\Models\AssetType;

/**
 * @class AssetTypeTableSeeder
 * @brief Inicializar Tipos de Bien
 * 
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AssetTypeTableSeeder extends Seeder
{
    /**
     * Método que registra los valores iniciales de tipos de bien
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function run()
    {
        
        Model::unguard();

        $asset_type = [
            ['name' => 'Mueble'],
            ['name' => 'Inmueble']
            
        ];


           
            foreach ($asset_type as $type) {
                AssetType::updateOrCreate(
                    ['name' => $type['name']]
                );
            }
    }
}
