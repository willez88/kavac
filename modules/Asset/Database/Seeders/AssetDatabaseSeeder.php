<?php

namespace Modules\Asset\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class AssetDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call(AssetTypeTableSeeder::class);
        $this->call(AssetCategoryTableSeeder::class);
        $this->call(AssetSubcategoryTableSeeder::class);
        $this->call(AssetSpecificcategoryTableSeeder::class);
    }
}
