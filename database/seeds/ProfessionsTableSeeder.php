<?php

use Illuminate\Database\Seeder;

use App\Models\Profession;

class ProfessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $professions = [
        	['name' => 'Abogado(a)', 'acronym' => 'Abg'],
        	['name' => 'Arquitecto(a)', 'acronym' => 'Arq'],
        	['name' => 'Bachiller', 'acronym' => 'Bach'],
        	['name' => 'Criminólogo(a)', 'acronym' => ''],
        	['name' => 'Doctor(a)', 'acronym' => 'Dr'],
        	['name' => 'Doctor(a) en Ciencias Computacionales', 'acronym' => 'Dr'],
        	['name' => 'Economista', 'acronym' => 'Eco'],
        	['name' => 'Ingeniero(a) Civil', 'acronym' => 'Ing'],
        	['name' => 'Ingeniero(a) de Sistemas', 'acronym' => 'Ing'],
        	['name' => 'Ingeniero(a) Electricista', 'acronym' => 'Ing'],
        	['name' => 'Ingeniero(a) en Computación', 'acronym' => 'Ing'],
        	['name' => 'Ingeniero(a) en Electrónica', 'acronym' => 'Ing'],
        	['name' => 'Ingeniero(a) en Informática', 'acronym' => 'Ing'],
        	['name' => 'Ingeniero(a) Industrial', 'acronym' => 'Ing'],
        	['name' => 'Ingeniero(a) Mecánico', 'acronym' => 'Ing'],
        	['name' => 'Licenciado(a) en Administración', 'acronym' => 'Lic'],
        	['name' => 'Licenciado(a) en Ciencias Gerenciales', 'acronym' => 'Lic'],
        	['name' => 'Licenciado(a) en Comunicación Social', 'acronym' => 'Lic'],
        	['name' => 'Licenciado(a) en Contaduría Pública', 'acronym' => 'Lic'],
        	['name' => 'Licenciado(a) en Estadística', 'acronym' => 'Lic'],
        	['name' => 'Ninguna', 'acronym' => ''],
        	['name' => 'Politologo(a)', 'acronym' => 'Pol'],
        	['name' => 'T.S.U. en Administración', 'acronym' => 'T.S.U.'],
        	['name' => 'T.S.U. en Contaduría', 'acronym' => 'T.S.U.'],
        	['name' => 'T.S.U. en Informática', 'acronym' => 'T.S.U.'],
        	['name' => 'T.S.U. en Diseño', 'acronym' => 'T.S.U.'],
        	['name' => 'T.S.U. en Electrónica', 'acronym' => 'T.S.U.'],
        ];

        foreach ($professions as $profession) {
        	Profession::updateOrCreate(
        		['name' => $profession['name']],
        		['acronym' => ($profession['acronym'])?$profession['acronym']:null]
        	);
        }
    }
}
