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
        /** Roles disponibles para el acceso al sistema */
        $this->call(RolesTableSeeder::class);
        /** Permisos disponibles para el acceso al sistema */
        $this->call(PermissionsTableSeeder::class);
        /** Usuarios por defecto */
        $this->call(UsersTableSeeder::class);
        /** Configuración por defecto */
        $this->call(SettingsTableSeeder::class);
        /** Registros de países */
        $this->call(CountriesTableSeeder::class);
        /** Registros de Estados asociados a los países */
        $this->call(EstatesTableSeeder::class);
        /** Registros de Municipios asociados a los Estados */
        $this->call(MunicipalitiesTableSeeder::class);
        /** Registros de Parroquias asociadas a los Municipios */
        $this->call(ParishesTableSeeder::class);
        /** Registros de Ciudades asociadas a los Estados */
        $this->call(CitiesTableSeeder::class);
        /** Sectores por defecto para el registro de instituciones */
        $this->call(InstitutionSectorsTableSeeder::class);
        /** Tipos de instituciones por defecto */
        $this->call(InstitutionTypesTableSeeder::class);
        /** Estados civiles */
        $this->call(MaritalStatusTableSeeder::class);
        /** Profesiones */
        $this->call(ProfessionsTableSeeder::class);
        /** Estatus de los documentos */
        $this->call(DocumentStatusTableSeeder::class);
        /** Tipos de moneda por defecto */
        $this->call(CurrenciesTableSeeder::class);
    }
}
