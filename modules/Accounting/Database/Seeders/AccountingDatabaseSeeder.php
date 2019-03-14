<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
/**
 * @class AccountingDatabaseSeeder
 * @brief Información por defecto para datos iniciales del módulo Accounting
 * 
 * Gestiona la información por defecto a registrar inicialmente para los datos iniciales del módulo Accounting
 * 
 * @author Juan Rosas <JuanFBass17@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        /** Seeder para registro de cuentas patrimoniales */
        $this->call(AccountingAccountsTableSeeder::class);
    }
}
