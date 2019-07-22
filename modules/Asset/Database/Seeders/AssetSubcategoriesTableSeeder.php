<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Asset\Models\AssetCategory;
use Modules\Asset\Models\AssetSubcategory;

/**
 * @class AssetSubcategoriesTableSeeder
 * @brief Inicializa Subcategorias de un Bien
 * 
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetSubcategoriesTableSeeder extends Seeder
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

        $asset_subcategories = [

            "01" => [
                    "01" => "Maquinaria y equipos de construcción y mantenimiento",
                    "02" => "Maquinarias y equipos para mantenimiento de automotores",
                    "03" => "Maquinarias y equipos agrícolas y pecuarios",
                    "04" => "Maquinarias y equipos de artes gráficas y reproducción",
                    "05" => "Maquinarias y equipos industriales y de taller",
                    "06" => "Maquinarias y equipos de energía",
                    "07" => "Maquinarias y equipos de riego y acueductos",
                    "08" => "Equipos de almacén",
                    "09" => "Otras maquinarias y demás equipos de construcción, campo, industria y taller"
                ],
            "02" => [
                    "01" => "Vehículos automotores terrestres",
                    "02" => "Equipos ferroviarios y de cables aéreos",
                    "03" => "Equipos marítimos de transporte",
                    "04" => "Equipos aéreos de transporte",
                    "05" => "Vehículos de tracción no motorizados",
                    "06" => "Equipos auxiliares de transporte",
                    "07" => "Otros equipos de transporte, tracción y elevación"
                ],

            "03" => [
                    "01" => "Equipos de telecomunicaciones",
                    "02" => "Equipos de señalamiento",
                    "03" => "Equipos de control de tráfico aéreo",
                    "04" => "Equipos de correo",
                    "05" => "Otros equipos de comunicaciones y de señalamiento"
                ],

            "04" => [
                    "01" => "Equipos médicos - quirúrgicos, dentales y veterinarios",
                    "02" => "Otros Equipos médicos - quirúrgicos, dentales y veterinarios"
                ],

            "05" => [
                    "01" => "Equipos científicos y de laboratorio",
                    "02" => "Equipos de enseñanza, deporte y recreación",
                    "03" => "Obras de arte",
                    "04" => "Libros y revistas",
                    "05" => "Equipos religiosos",
                    "06" => "Instrumentos musicales",
                    "07" => "Otros equipos científicos, religiosos, de enseñanza y recreación"
                ],

            "06" => [
                    "01" => "Equipos y armamentos de defensa y seguridad pública",
                    "02" => "Otros equipos para la defensa y seguridad pública"
                ],

            "07" => [
                    "01" => "Mobiliario y equipos de oficina",
                    "02" => "Equipos de procesamiento de datos",
                    "03" => "Mobiliario y equipos de alojamiento",
                    "04" => "Otras máquinas, muebles y demás equipos de oficina y de alojamiento"
                ],

            "08" => [
                    "01" => "Semovientes"
                ],

            "09" => [
                    "01" => "Edificaciones",
                    "02" => "Tierras y Terrenos"
            ]

        ];


        foreach ($asset_subcategories as $key => $subcategories) {

            $asset_category = AssetCategory::where('id',$key)->first();
            foreach ($subcategories as $code => $subcat) {
                AssetSubcategory::UpdateorCreate([
                    'code' => $code,
                    'name' => $subcat,
                    'asset_category_id' => $asset_category->id],[]);
            }
        }
    }
}
