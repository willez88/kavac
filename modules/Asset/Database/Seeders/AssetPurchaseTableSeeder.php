<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Asset\Models\AssetPurchase;

/**
 * @class AssetPurchaseTableSeeder
 * @brief Inicializar Formas de Adquisición
 * 
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetPurchaseTableSeeder extends Seeder
{
    /**
     * Método que registra los valores iniciales de las formas de adquisición de un bien
     *
     * @author  Henry Paredes (henryp2804@gmail.com)
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $asset_purchase = [
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


           
            foreach ($asset_purchase as $purchase) {
                AssetPurchase::updateOrCreate(
                    ['name' => $purchase['name']]
                );
            }
    }
}
