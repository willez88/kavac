<?php
/** [descripción del namespace] */
namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Payroll\Models\PayrollLicenseDegree;
use DB;

/**
 * @class $CLASS$
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollLicenseDegreesTableSeeder extends Seeder
{
    /**
     * Ejecuta los seeds de la base de datos
     *
     * @method run
     *
     * @return void     [descripción de los datos devueltos]
     */
    public function run()
    {
        Model::unguard();

        $licenses = [
            [
                'name' => '1º Grado',
                'description' => 'Tipo "A" para conducir vehículos de tracción humana y Tipo "B" ' .
                                 'para conducir vehículos de tracción animal'
            ],
            [
                'name' => '2º Grado',
                'description' => 'Tipo "A" para menores de edad a partir de 16 años con ' .
                                 'autorización legal para conducir motocicletas hasta 80cc., ' .
                                 'y Tipo "B" para mayores de edad para conducir motocicleta de ' .
                                 'cualquier cilindrada'
            ],
            [
                'name' => '3º Grado',
                'description' => 'Permite conducir automóviles de transporte privado de personas ' .
                                 'con un límite de 9 puestos y/o vehículos que transporte ' .
                                 'mercancia menor a 2500 kilogramos'
            ],
            [
                'name' => '4º Grado',
                'description' => 'Permite conducir vehículos de transporte público hasta 12 ' .
                                 'puestos, o vehículos de carga que no exceda los 6000 kilogramos'
            ],
            [
                'name' => '5º Grado',
                'description' => 'Permite conducir transporte público hasta 33 puestos, ' .
                                 'o vehículos de carga que no exceda los 9000 kilogramos'
            ],
            [
                'name' => 'Título Superior Profesional (TSP)',
                'description' => 'Permite conducir unidades de transporte público superior a ' .
                                 '33 puestos, vehículos de carga que excedan los 9000 kilogramos ' .
                                 'y vehículos con cargas de alto riesgo'
            ]
        ];

        DB::transaction(function () use ($licenses) {
            foreach ($licenses as $license) {
                PayrollLicenseDegree::updateOrCreate(
                    ['name' => $license['name']],
                    ['description' => $license['description']]
                );
            }
        });
    }
}
