<?php

use Illuminate\Database\Seeder;

/**
 * @class DatabaseSeeder
 * @brief Gestiona los seeder de la aplicación
 * 
 * Invoca las clases de los seeder encargados de registrar información inicial en el sistema
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
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
        $this->call(DocumentStatusTableSeeder::class);
        $this->call(PermissionsTableSeeder::class);
        $this->call(CurrenciesTableSeeder::class);
    }
}
