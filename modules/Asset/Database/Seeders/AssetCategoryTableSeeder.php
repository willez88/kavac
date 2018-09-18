<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\Asset\Models\Type;
use Modules\Asset\Models\Category;


class AssetCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
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

            $asset_type = Type::where('id',$key)->first();
            foreach ($categories as $code => $cat) {
                Category::UpdateorCreate([
                    'code' => $code,
                    'name' => $cat,
                    'asset_type_id' => $asset_type->id],[]);
            }
        }
    }
}
