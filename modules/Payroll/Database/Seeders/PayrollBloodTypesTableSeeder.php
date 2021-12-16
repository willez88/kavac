<?php
/** [descripción del namespace] */
namespace Modules\Payroll\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Payroll\Models\PayrollBloodType;
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
class PayrollBloodTypesTableSeeder extends Seeder
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

        $bloodTypes = [
            'A positivo (A+)',
            'A negativo (A-)',
            'B positivo (B+)',
            'B negativo (B-)',
            'AB positivo (AB+)',
            'AB negativo (AB-)',
            'O positivo (O+)',
            'O negativo (O-)',
        ];

        DB::transaction(function () use ($bloodTypes) {
            foreach ($bloodTypes as $bloodType) {
                PayrollBloodType::updateOrCreate(['name' => $bloodType]);
            }
        });
    }
}
