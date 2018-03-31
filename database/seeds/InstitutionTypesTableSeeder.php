<?php

use Illuminate\Database\Seeder;

use App\Models\InstitutionType;

class InstitutionTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        InstitutionType::updateOrCreate(
        	['acronym' => 'EDSF'],
        	['name' => 'Ente Desentralizado sin fines empresariales']
        );
        InstitutionType::updateOrCreate(
        	['acronym' => 'ALCD'],
        	['name' => 'Alcaldía']
        );
        InstitutionType::updateOrCreate(
        	['acronym' => 'MINS'],
        	['name' => 'Ministerio']
        );
        InstitutionType::updateOrCreate(
        	['acronym' => 'GOBR'],
        	['name' => 'Gobernación']
        );
    }
}
