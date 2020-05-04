<?php

namespace Modules\Sale\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Sale\Models\SaleSettingProductType;

/**
 * @class SaleSettingProductTypeTableSeeder
 * @brief Inicializar los tipos de producto
 *
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */

class SaleSettingProductTypeTableSeeder extends Seeder
{
     /**
     * Método que registra los valores de los tipos de producto
     *
     * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $saleSettingProductType = [
            [
                'name' => 'Producto'
            ],
            [
                'name' => 'Servicio'
            ],
        ];

        DB::transaction(function () use ($saleSettingProductType) {
            foreach ($saleSettingProductType as $saleSettingProductType) {
                saleSettingProductType::Create(
                    ['name' => $saleSettingProductType['name']],
                );
            }
        });
    }
}
