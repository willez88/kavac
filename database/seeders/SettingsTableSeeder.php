<?php
namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

/**
 * @class SettingsTableSeeder
 * @brief Información por defecto para Configuraciones
 *
 * Gestiona la información por defecto a registrar inicialmente para las Configuraciones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::transaction(function () {
            Setting::withTrashed()->updateOrCreate(['active' => true], ['deleted_at' => null]);
        });
    }
}
