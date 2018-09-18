<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Modules\Asset\Models\Type;

class AssetTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $asset_type = [
            ['name' => 'Mueble'],
            ['name' => 'Inmueble']
            
        ];


           
            foreach ($asset_type as $type) {
                Type::updateOrCreate(
                    ['name' => $type['name']]
                );
            }
    }
}
