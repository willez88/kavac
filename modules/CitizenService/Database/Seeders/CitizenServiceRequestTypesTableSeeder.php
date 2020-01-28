<?php

namespace Modules\CitizenService\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Modules\CitizenService\Models\CitizenServiceRequestType;

class CitizenServiceRequestTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $citizenServiceRequestTypes = [
            ['name' => 'Soporte técnico'],
            ['name' => 'Migración a software libre'],
            ['name' => 'Talleres de formación - asesorias'],
            ['name' => 'Desarrollo de software libre']
            
        ];


           
        foreach ($citizenServiceRequestTypes as $citizenServiceRequestType) {
            CitizenServiceRequestType::updateOrCreate(
                ['name' => $citizenServiceRequestType['name']]
            );
        }
    }
}
