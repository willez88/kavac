<?php

use Illuminate\Database\Seeder;

use App\Models\InstitutionSector;

class InstitutionSectorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InstitutionSector::updateOrCreate(['name' => 'Desarrollo'],[]);
        InstitutionSector::updateOrCreate(['name' => 'Ciencia y Tecnología'],[]);
        InstitutionSector::updateOrCreate(['name' => 'Gobierno'],[]);
    }
}
