<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Asset\Models\AssetType;
use Modules\Asset\Models\AssetCategory;

/**
 * @class AssetCategoriesTableSeeder
 * @brief Inicializa Categorias Generales
 *
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetCategoriesTableSeeder extends Seeder
{
    /**
     * Método que registra los valores iniciales de Categorias Generales de un Bien
     *
     * @author  Henry Paredes <hparedes@cenditel.gob.ve>
     * @return void
     */
    public function run()
    {
        Model::unguard();


        $asset_categories = [

            "01" => [
                    "01" => "Maquinaria y demás equipos de construcción, campo, industria y taller",
                    "02" => "Equipos de transporte, tracción y elevación",
                    "03" => "Equipos de comunicaciones y de señalamiento",
                    "04" => "Equipos médicos - quirúrgicos, dentales y veterinarios",
                    "05" => "Equipos científicos, religiosos, de enseñanza y recreación",
                    "06" => "Equipos de defensa y seguridad del Estado",
                    "07" => "Máquinas, muebles y demás equipos de oficina y de alojamiento",
                    "08" => "Semovientes"
                   ],
            "02" => [
                    "01" => 'Edificaciones, Tierras y Terrenos'
                   ]
        ];


        foreach ($asset_categories as $key => $categories) {
            $asset_type = AssetType::where('id', $key)->first();
            foreach ($categories as $code => $cat) {
                AssetCategory::UpdateorCreate([
                    'code' => $code,
                    'name' => $cat,
                    'asset_type_id' => $asset_type->id], []);
            }
        }
    }
}
