<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(EstatesTableSeeder::class);
        $this->call(MunicipalitiesTableSeeder::class);
        $this->call(ParishesTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(InstitutionSectorsTableSeeder::class);
        $this->call(InstitutionTypesTableSeeder::class);
        $this->call(MaritalStatusTableSeeder::class);
        $this->call(ProfessionsTableSeeder::class);
    }
}
