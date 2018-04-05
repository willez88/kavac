<?php

use Illuminate\Database\Seeder;

use App\Models\MaritalStatus;

class MaritalStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        MaritalStatus::updateOrCreate(['name' => 'Soltero(a)'],[]);
        MaritalStatus::updateOrCreate(['name' => 'Casado(a)'],[]);
        MaritalStatus::updateOrCreate(['name' => 'Divorciado(a)'],[]);
        MaritalStatus::updateOrCreate(['name' => 'Viudo(a)'],[]);
    }
}
