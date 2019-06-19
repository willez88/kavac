<?php

namespace Modules\Accounting\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Accounting\Models\AccountingAccount;

/**
 * @class AccountingAccountsTableSeeder
 * @brief Información por defecto para cuentas patrimoniales
 * 
 * Gestiona la información por defecto a registrar inicialmente para las cuentas patrimoniales
 * 
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingAccountsTableSeeder extends Seeder
{
    /**
     * @class AccountingAccountsTableSeeder
     * @brief Información por defecto para cuentas patrimoniales
     * 
     * Gestiona la información por defecto y la registra inicialmente para las cuentas patrimoniales
     * 
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
     */
    public function run()
    {
        Model::unguard();

        $accounting_acounts = [
            [
                'group' => '1','subgroup' => '0','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ACTIVO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ACTIVO CORRIENTE'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ACTIVO DISPONIBLE'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CAJA Y BANCOS'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Caja'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Bancos'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '01',
                'active' => true,
                'denomination' => 'Bancos públicos'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '02',
                'active' => true,
                'denomination' => 'Bancos privados'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '03',
                'active' => true,
                'denomination' => 'Bancos del exterior'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INVERSIONES TEMPORALES'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ACTIVO EXIGIBLE'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INVERSIONES FINANCIERAS EN TÍTULOS Y VALORES A CORTO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Inversiones en títulos y valores privados a corto plazo'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Inversiones en títulos y valores públicos a corto plazo'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Inversiones en títulos y valores externos a corto plazo'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PRÉSTAMOS POR COBRAR A CORTO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo al sector privado'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo al sector público'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '01',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo a la República'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '02',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo a entes descentralizados sin fines empresariales'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '03',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo a instituciones de protección social'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '04',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo a entes descentralizados con fines empresariales petroleros'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '05',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo a entes descentralizados con fines empresariales no petroleros'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '06',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo a entes descentralizados financieros bancarios'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '07',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo a entes descentralizados financieros no bancarios'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '08',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo al Poder Estadal'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '09',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo al Poder Municipal'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo al sector externo'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '03','subspecific' => '01',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo a instituciones sin fines de lucro'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '03','subspecific' => '02',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo a gobiernos extranjeros'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '03','subspecific' => '03',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a corto plazo a organismos internacionales'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CUENTAS POR COBRAR A CORTO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '03','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Cuentas comerciales por cobrar a corto plazo'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '03','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deudas de corto plazo por rendir de fondos en avance'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '03','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deudas de corto plazo por rendir de fondos en anticipo'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '03','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otras cuentas por cobrar a corto plazo'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'EFECTOS POR COBRAR A CORTO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '04','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Efectos comerciales por cobrar a corto plazo'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '04','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otros efectos por cobrar a corto plazo'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FONDOS EN AVANCE'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '06','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FONDOS EN ANTICIPO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '07','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FONDOS Y BIENES EN FIDEICOMISO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '09','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ANTICIPOS A PROVEEDORES A CORTO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '2', 'generic' => '10','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ANTICIPOS A CONTRATISTAS POR CONTRATOS DE CORTO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '3', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ACTIVO REALIZABLE'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INVENTARIO DE MATERIA PRIMA'
            ],

            [
                'group' => '1','subgroup' => '1','item' => '3', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INVENTARIO DE PRODUCTOS TERMINADOS'
            ],

            [
                'group' => '1','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INVENTARIO DE PRODUCTOS EN PROCESO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '3', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INVENTARIO DE MERCANCÍAS'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '3', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INVENTARIO DE MATERIALES Y SUMINISTROS'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '3', 'generic' => '06','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'BIENES Y MATERIALES EN TRÁNSITO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '3', 'generic' => '06','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Bienes y materiales importados en tránsito'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '3', 'generic' => '06','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Bienes y materiales locales en tránsito'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '3', 'generic' => '06','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Bienes y materiales en tránsito entre almacenes'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '4', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ACTIVOS DIFERIDOS A CORTO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'GASTOS PAGADOS POR ANTICIPADO A CORTO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses de la deuda publica interna a corto plazo pagados por anticipado'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses de la deuda publica externa a corto plazo pagados por anticipado'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otros intereses a corto plazo pagados por anticipado'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Débitos por apertura de cartas de crédito a corto plazo'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otros gastos a corto plazo pagados por anticipado'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '4', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEPÓSITOS OTORGADOS EN GARANTÍA A CORTO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS ACTIVOS DIFERIDOS A CORTO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '9', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS ACTIVOS CORRIENTES'
            ],
            [
                'group' => '1','subgroup' => '1','item' => '9', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS ACTIVOS CORRIENTES'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ACTIVO NO CORRIENTE'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INVERSIONES FINANCIERAS A LARGO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INVERSIONES FINANCIERAS EN ACCIONES Y PARTICIPACIONES DE CAPITAL A LARGO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Inversiones en acciones y participaciones de capital a largo plazo al sector privado'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Inversiones en acciones y participaciones de capital a largo plazo al sector público'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '01',
                'active' => true,
                'denomination' => 'Inversiones en acciones y participaciones de capital a largo plazo a entes descentralizados sin fines empresariales'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '02',
                'active' => true,
                'denomination' => 'Inversiones en acciones y participaciones de capital a largo plazo a instituciones de protección social'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '03',
                'active' => true,
                'denomination' => 'Inversiones en acciones y participaciones de capital a largo plazo a entes descentralizados con fines empresariales petroleros'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '04',
                'active' => true,
                'denomination' => 'Inversiones en acciones y participaciones de capital a largo plazo a entes descentralizados con fines empresariales no petroleros'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '05',
                'active' => true,
                'denomination' => 'Inversiones en acciones y participaciones de capital a largo plazo a entes descentralizados financieros bancarios'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '06',
                'active' => true,
                'denomination' => 'Inversiones en acciones y participaciones de capital a largo plazo a entes descentralizados financieros no bancarios'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '07',
                'active' => true,
                'denomination' => 'Inversiones en acciones y participaciones de capital a largo plazo a organismos del sector público para el pago de su deuda'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Inversiones en acciones y participaciones de capital a largo plazo al sector externo'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '03','subspecific' => '01',
                'active' => true,
                'denomination' => 'Inversiones en acciones y participaciones de capital a largo plazo a organismos internacionales'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '03','subspecific' => '99',
                'active' => true,
                'denomination' => 'Otras inversiones en acciones y participaciones de capital a largo plazo al sector externo'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INVERSIONES FINANCIERAS EN TÍTULOS Y VALORES A LARGO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Inversiones en tí tulos y valores privados a largo plazo'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Inversiones en tí tulos y valores públicos a largo plazo'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Inversiones en tí tulos y valores externos a largo plazo'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PRÉSTAMOS POR COBRAR A LARGO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo al sector privado'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo al sector público'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '02','subspecific' => '01',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo a la República'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '02','subspecific' => '02',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo a los entes descentralizados sin fines empresariales'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '02','subspecific' => '03',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo a instituciones de protección social'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '02','subspecific' => '04',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo a entes descentralizados con fines empresariales petroleros'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '02','subspecific' => '05',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo a entes descentralizados con fines empresariales no petroleros'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '02','subspecific' => '06',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo a entes financieros bancarios'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '02','subspecific' => '07',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo a entes financieros no bancarios'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '02','subspecific' => '08',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo al Poder Estadal'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '02','subspecific' => '09',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo al Poder Municipal'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo al sector externo'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '03','subspecific' => '01',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo a instituciones sin fines de lucro'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '03','subspecific' => '02',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo a gobiernos extranjeros'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '03','subspecific' => '03',
                'active' => true,
                'denomination' => 'Préstamos por cobrar a largo plazo a organismos internacionales'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FONDO DE ESTABILIZACIÓN MACROECONÓMICA'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '04','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Fondo de estabilización macroeconómica de la República'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '04','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Fondo de estabilización macroeconómica del Poder Estadal'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '04','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Fondo de estabilización macroeconómica del Poder Municipal'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FONDO DE AHORRO INTERGENERACIONAL'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FONDO DE APORTES AL SECTOR PÚBLICO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '2', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CUENTAS Y EFECTOS POR COBRAR A MEDIANO Y LARGO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '2', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CUENTAS POR COBRAR A MEDIANO Y LARGO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '2', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Cuentas comerciales por cobrar a mediano y largo plazo'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '2', 'generic' => '01','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otras cuentas por cobrar a mediano y largo plazo'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'EFECTOS POR COBRAR A MEDIANO Y LARGO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Efectos comerciales por cobrar a mediano y largo plazo'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otros efectos por cobrar a mediano y largo plazo'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '2', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ANTICIPOS A CONTRATISTAS POR CONTRATOS A MEDIANO Y LARGO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PROPIEDAD, PLANTA Y EQUIPO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'BIENES DE USO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Edificios e instalaciones'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Maquinaria y demás equipos de construcción, campo, industria y taller'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Equipos de transporte, tracción y elevación'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Equipos de comunicaciones y señalamiento'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Equipos médicos-quirúrgicos, dentales y veterinarios'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '06','subspecific' => '00',
                'active' => true,
                'denomination' => 'Equipos cientí ficos, religiosos, de enseñanza y recreación'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '07','subspecific' => '00',
                'active' => true,
                'denomination' => 'Equipos y armamentos de orden público, seguridad y defensa'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '08','subspecific' => '00',
                'active' => true,
                'denomination' => 'Máquinas, muebles y demás equipos de oficina y de alojamiento'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '09','subspecific' => '00',
                'active' => true,
                'denomination' => 'Semovientes'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otros bienes de uso'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TIERRAS Y TERRENOS'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TIERRAS Y TERRENOS EXPROPIADOS'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'EDIFICIOS E INSTALACIONES EXPROPIADOS'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CONSTRUCCIONES EN PROCESO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '05','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Construcciones en proceso de bienes del dominio privado'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '3', 'generic' => '05','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Construcciones en proceso de bienes del dominio público'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '4', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ACTIVO INTANGIBLE'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '4', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'MARCA DE FÁBRICA Y PATENTES DE INVENCIÓN'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '4', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DERECHOS DE AUTOR'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '4', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'GASTOS DE ORGANIZACIÓN'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '4', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PAQUETES Y PROGRAMAS DE COMPUTACIÓN'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '4', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ESTUDIOS Y PROYECTOS'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '4', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS ACTIVOS INTANGIBLES'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '5', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ACTIVOS DIFERIDOS A MEDIANO Y LARGO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'GASTOS PAGADOS POR ANTICIPADO A LARGO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses de la deuda pública interna a largo plazo pagados por anticipado'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses de la deuda pública externa a largo plazo pagados por anticipado'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '06','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otros intereses a mediano y largo plazo pagados por anticipado'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otros gastos a mediano y largo plazo pagados por anticipado'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '5', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEPÓSITOS OTORGADOS EN GARANTÍA A MEDIANO Y LARGO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '5', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS ACTIVOS DIFERIDOS A MEDIANO Y LARGO PLAZO'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '9', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS ACTIVOS NO CORRIENTES'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '9', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ACTIVOS EN PROCESO JUDICIAL'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '9', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Activos en gestión judicial a mediano y largo plazo'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '9', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Títulos y otros valores de la deuda pública en litigio a largo plazo'
            ],
            [
                'group' => '1','subgroup' => '2','item' => '9', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ACTIVOS NO CORRIENTES DIVERSOS A MEDIANO Y LARGO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '0','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PASIVO'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PASIVO CORRIENTE'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CUENTAS Y EFECTOS POR PAGAR A CORTO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'GASTOS DE PERSONAL POR PAGAR'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Sueldos, salarios y otras remuneraciones por pagar'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Complementos de sueldos y salarios por pagar'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Asistencia socio económica por pagar'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Prestaciones sociales e indemnizaciones por pagar'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Capacitación y adiestramiento por pagar'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otros gastos de personal por pagar'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'APORTES PATRONALES Y LEGALES POR PAGAR'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes patronales y legales por pagar al Instituto Venezolano de los Seguros Sociales (IVSS)'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes patronales por pagar al Instituto de Previsión y Asistencia Social del Ministerio de Educación (IPASME)'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes patronales por pagar al Fondo de Jubilaciones'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes patronales por pagar al Fondo de Seguro de Paro Forzoso'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes patronales por pagar al Fondo de Ahorro Obligatorio para la Vivienda (FAOV)'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '06','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes a los servicios de salud, accidentes personales y Gastos Funerarios'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '07','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes patronales por pagar a cajas de ahorro'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '08','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes patronales por pagar a los organismos de seguridad social'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '09','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes patronales por pagar al Instituto Nacional de Capacitación y Educación Socialista (INCES)'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otros aportes legales por pagar'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RETENCIONES LABORALES POR PAGAR'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '03','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Retenciones laborales por pagar al Instituto Venezolano de los Seguros Sociales (IVSS)'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '03','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Retenciones laborales por pagar al Instituto de Previsión y Asistencia Social del Ministerio de Educación (IPASME)'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '03','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Retenciones laborales por pagar al Fondo de Jubilaciones'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '03','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Retenciones laborales por pagar al Fondo de Seguro de Paro Forzoso'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '03','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Retenciones laborales por pagar al Fondo de Ahorro Obligatorio para la Vivienda (FAOV)'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '03','specific' => '06','subspecific' => '00',
                'active' => true,
                'denomination' => 'Retenciones laborales por pagar por servicios de salud, accidentes personales y Gastos Funerarios'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '03','specific' => '07','subspecific' => '00',
                'active' => true,
                'denomination' => 'Retenciones laborales por pagar a cajas de ahorro'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '03','specific' => '08','subspecific' => '00',
                'active' => true,
                'denomination' => 'Retenciones laborales por pagar al Instituto Nacional de Capacitación y Educación Socialista (INCES)'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '03','specific' => '09','subspecific' => '00',
                'active' => true,
                'denomination' => 'Retenciones laborales por pagar por pensión alimenticia'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '03','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otras retenciones laborales por pagar'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CUENTAS POR PAGAR A CORTO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '04','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Cuentas por pagar a proveedores a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '04','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Cuentas por pagar a contratistas a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '04','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Obligaciones de ejercicios anteriores'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '04','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otras cuentas por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'EFECTOS POR PAGAR A CORTO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '05','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Efectos por pagar a proveedores a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '05','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Efectos por pagar a contratistas a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '05','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otros efectos por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '06','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INTERESES POR PAGAR A CORTO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '06','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses internos por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '1', 'generic' => '06','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses externos por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEUDA PÚBLICA A CORTO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEUDA PUBLICA INTERNA POR TÍTULOS Y VALORES A CORTO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Bonos y otros valores de la deuda pública interna a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Letras del Tesoro a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEUDA PUBLICA INTERNA POR PRÉSTAMOS POR PAGAR A CORTO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos del sector privado por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos de la República por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos de entes descentralizados sin fines empresariales por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos de instituciones de protección social por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos de entes descentralizados con fines empresariales petroleros por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '06','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos de entes descentralizados con fines empresariales no petroleros por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '07','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos de entes descentralizados financieros bancarios por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '08','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos de entes descentralizados financieros no bancarios por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '09','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos del Poder Estadal por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '10','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos del Poder Municipal por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEUDA PUBLICA EXTERNA POR TÍTULOS Y VALORES A CORTO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '03','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Títulos y valores de la deuda pública externa a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEUDA PUBLICA EXTERNA POR PRÉSTAMOS POR PAGAR A CORTO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '04','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda externa por préstamos recibidos de gobiernos extranjeros por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '04','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda externa por préstamos recibidos de organismos internacionales por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '04','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda externa por préstamos recibidos de instituciones financieras externas por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '04','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda externa por préstamos recibidos de proveedores de bienes y servicios externos por pagar a corto plazo'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OBLIGACIONES DE EJERCICIOS ANTERIORES DERIVADAS DE DEUDA PÚBLICA'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '09','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEUDA PÚBLICA A CORTO PLAZO POR DISTRIBUIR'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '09','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda pública interna a corto plazo por distribuir'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '2', 'generic' => '09','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda pública externa a corto plazo por distribuir'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '3', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PASIVOS DIFERIDOS'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PASIVOS DIFERIDOS A CORTO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FONDOS DE TERCEROS'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEPÓSITOS RECIBIDOS EN GARANTÍA'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS FONDOS DE TERCEROS'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Retenciones de impuestos'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '01','subspecific' => '01',
                'active' => true,
                'denomination' => 'Retenciones por pagar por concepto de impuesto sobre la renta'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '01','subspecific' => '02',
                'active' => true,
                'denomination' => 'Retenciones por pagar por concepto de impuesto al valor agregado'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '01','subspecific' => '03',
                'active' => true,
                'denomination' => 'Retenciones por pagar por concepto de impuesto al uno por mil (1x1000)'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '01','subspecific' => '99',
                'active' => true,
                'denomination' => 'Otras retenciones de impuesto por pagar'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Retenciones contractuales'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '02','subspecific' => '01',
                'active' => true,
                'denomination' => 'Retenciones efectuadas a proveedores pendientes de devolución'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '02','subspecific' => '02',
                'active' => true,
                'denomination' => 'Retenciones efectuadas a contratistas pendientes de devolución'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Retenciones al personal jubilado'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '03','subspecific' => '01',
                'active' => true,
                'denomination' => 'Retenciones efectuadas al personal jubilado por pagar por servicios de salud, accidentes personales y gastos funerarios'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '03','subspecific' => '02',
                'active' => true,
                'denomination' => 'Retenciones efectuadas al personal jubilado por pagar a cajas de ahorro'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '03','subspecific' => '99',
                'active' => true,
                'denomination' => 'Otras retenciones efectuadas al personal jubilado por pagar a sus legítimos beneficiarios'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '9', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS PASIVOS CORRIENTES'
            ],
            [
                'group' => '2','subgroup' => '1','item' => '9', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS PASIVOS CORRIENTES'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PASIVO NO CORRIENTE'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CUENTAS Y EFECTOS POR PAGAR A MEDIANO Y LARGO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CUENTAS POR PAGAR A MEDIANO Y LARGO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Cuentas por pagar a proveedores a mediano y largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Cuentas por pagar a contratistas a mediano y largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'EFECTOS POR PAGAR A MEDIANO Y LARGO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Efectos por pagar a proveedores a mediano y largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Efectos por pagar a contratistas a mediano y largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEUDA PÚBLICA A LARGO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEUDA PUBLICA INTERNA POR TÍTULOS Y VALORES A LARGO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Bonos y otros valores de la deuda pública interna a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEUDA PUBLICA INTERNA POR PRÉSTAMOS POR PAGAR A LARGO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos del sector privado por pagar a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos de la República por pagar a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos de entes descentralizados sin fines empresariales por pagar a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos de instituciones de protección social por pagar a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos de entes descentralizados con fines empresariales petroleros por pagar a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '06','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos de entes descentralizados con fines empresariales no petroleros por pagar a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '07','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos de entes descentralizados financieros bancarios por pagar a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '08','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos de entes descentralizados financieros no bancarios por pagar a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '09','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos del Poder Estadal por pagar a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '10','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda interna por préstamos recibidos del Poder Municipal por pagar a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEUDA PUBLICA EXTERNA POR TÍTULOS Y VALORES A LARGO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '03','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Títulos y valores de la deuda pública externa a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEUDA PUBLICA EXTERNA POR PRÉSTAMOS POR PAGAR A LARGO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '04','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda externa por préstamos recibidos de gobiernos extranjeros por pagar a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '04','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda externa por préstamos recibidos de organismos internacionales por pagar a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '04','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda externa por préstamos recibidos de instituciones financieras externas por pagar a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '04','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda externa por préstamos recibidos de proveedores de bienes y servicios externos por pagar a largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '09','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEUDA PÚBLICA A LARGO PLAZO POR DISTRIBUIR'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '09','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda pública interna a largo plazo por distribuir'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '2', 'generic' => '09','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deuda pública externa a largo plazo por distribuir'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '3', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PASIVOS DIFERIDOS'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PASIVOS DIFERIDOS A MEDIANO Y LARGO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Certificados de reintegro tributario a mediano y largo plazo'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Bonos de exportación'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Bonos en dación de pagos'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '4', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PROVISIONES Y RESERVAS TÉCNICAS'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '4', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PROVISIONES'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '4', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Provisión para cuentas incobrables'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '4', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Provisión para despidos'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '4', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Provisión para pérdidas en el inventario'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '4', 'generic' => '01','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Provisión para beneficios sociales'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '4', 'generic' => '01','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otras provisiones'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '4', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RESERVAS TÉCNICAS'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEPRECIACIÓN Y AMORTIZACIÓN ACUMULADAS'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEPRECIACIÓN ACUMULADA DE BIENES DE USO'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación acumulada de edificios e instalaciones'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación acumulada de maquinaria y demás equipos de construcción, campo, industria y taller'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación acumulada de equipos de transporte, tracción y elevación'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación acumulada de equipos de comunicaciones y señalamiento'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación acumulada de equipos médico-quirúrgicos, dentales y veterinarios'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '06','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación acumulada de equipos cientí ficos, religiosos, de enseñanza y recreación'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '07','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación acumulada de equipos y armamento de orden público, seguridad y defensa'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '08','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación acumulada de máquinas, muebles y demás equipos de oficina y de alojamiento'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '09','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación acumulada de semovientes'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación acumulada de otros bienes de uso'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'AMORTIZACIÓN ACUMULADA DE ACTIVOS INTANGIBLES'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Amortización acumulada de marcas de fábrica y patentes de invención'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Amortización acumulada de derechos de autor'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '02','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Amortización acumulada de gastos de organización'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '02','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Amortización acumulada de paquetes y programas de computación'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '02','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Amortización acumulada de estudios y proyectos'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '5', 'generic' => '02','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Amortización acumulada de otros activos intangibles'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '9', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS PASIVOS A MEDIANO Y LARGO PLAZO'
            ],
            [
                'group' => '2','subgroup' => '2','item' => '9', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS PASIVOS NO CORRIENTES'
            ],
            [
                'group' => '3','subgroup' => '0','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PATRIMONIO'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'HACIENDA PÚBLICA'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CAPITAL FISCAL'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CAPITAL FISCAL'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '2', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TRANSFERENCIAS Y DONACIONES DE CAPITAL RECIBIDAS'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TRANSFERENCIAS DE CAPITAL RECIBIDAS'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Transferencias de capital recibidas del sector privado'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Transferencias de capital recibidas del sector público'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Transferencias de capital recibidas del exterior'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otras transferencias de capital recibidas del sector público'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DONACIONES DE CAPITAL RECIBIDAS'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Donaciones de capital internas recibidas'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Donaciones de capital externas recibidas'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SITUADO Y APORTES ESPECIALES'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SITUADO'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Situado Constitucional'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '01','subspecific' => '01',
                'active' => true,
                'denomination' => 'Situado Estadal'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '01','subspecific' => '02',
                'active' => true,
                'denomination' => 'Situado Municipal'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Situado Estadal a Municipal'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SUBSIDIO DE RÉGIMEN ESPECIAL'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ASIGNACIONES ECONÓMICAS ESPECIALES'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Asignaciones económicas especiales – Estadal'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Asignaciones económicas especiales - Estadal a Municipal'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Asignaciones económicas especiales - Municipal'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Asignaciones económicas especiales - Fondo Nacional de los Consejos Comunales'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Asignaciones económicas especiales - Apoyo al Fortalecimiento Institucional'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FONDO INTERGUBERNAMENTAL PARA LA DESCENTRALIZACIÓN'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FONDO DE COMPENSACIÓN INTERTERRITORIAL'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '05','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Fondo de Compensación Interterritorial Estadal'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '05','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Fondo de Compensación Interterritorial Municipal'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '05','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Fondo de Compensación Interterritorial Poder Popular'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '05','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Fondo de Compensación Interterritorial Fortalecimiento Institucional'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '06','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'APORTES DEL SECTOR PÚBLICO AL PODER ESTADAL Y AL PODER MUNICIPAL POR TRANSFERENCIA DE SERVICIOS'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '06','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes del Sector Público al Poder Estadal por transferencia de servicios'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '06','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes del Sector Público al Poder Municipal por transferencia de servicios'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '07','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TRANSFERENCIAS Y DONACIONES DE CAPITAL DE ORGANISMOS DEL SECTOR PÚBLICO RECIBIDAS POR LOS CONSEJOS COMUNALES'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '07','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Transferencias de capital de organismos del sector público recibidas por los Consejos Comunales'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '3', 'generic' => '07','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Donaciones de capital de organismos del sector público recibidas por los Consejos Comunales'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '4', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'AJUSTE POR INFLACIÓN'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'AJUSTE POR INFLACIÓN'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '5', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RESULTADOS'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '5', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RESULTADOS ACUMULADOS'
            ],
            [
                'group' => '3','subgroup' => '1','item' => '5', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RESULTADOS DEL EJERCICIO'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PATRIMONIO INSTITUCIONAL'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CAPITAL INSTITUCIONAL'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CAPITAL INSTITUCIONAL'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '2', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TRANSFERENCIAS, DONACIONES DE CAPITAL Y APORTES POR CAPITALIZAR RECIBIDOS'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '2', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TRANSFERENCIAS DE CAPITAL RECIBIDAS'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '2', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Transferencias de capital internas recibidas del sector privado'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '2', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Transferencias de capital internas recibidas del sector público'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '2', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Transferencias de capital recibidas del exterior'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '2', 'generic' => '01','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otras transferencias de capital internas recibidas del sector público'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DONACIONES DE CAPITAL RECIBIDAS'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Donaciones de capital internas recibidas'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Donaciones de capital externas recibidas'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '2', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'APORTES POR CAPITALIZAR RECIBIDOS'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '2', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DIVIDENDOS POR DISTRIBUIR'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '3', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RESERVAS'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '3', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RESERVAS LEGALES Y ESTATUTARIAS'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '4', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'AJUSTE POR INFLACIÓN'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '4', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'AJUSTE POR INFLACIÓN'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '5', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RESULTADOS'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '5', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RESULTADOS ACUMULADOS'
            ],
            [
                'group' => '3','subgroup' => '2','item' => '5', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RESULTADOS DEL EJERCICIO'
            ],
            [
                'group' => '4','subgroup' => '0','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CUENTAS DE ORDEN'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CUENTAS DE ORDEN DEUDORAS'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DIVERSAS'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'COMPROMISOS FUTUROS'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FIANZAS Y GARANTÍAS A FAVOR DE LA ENTIDAD'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Fondos en garantí a'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Títulos y valores recibidos en garantía'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Documentos representativos de fianzas a favor de la entidad'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otras garantías a favor de la entidad'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'MERCANCÍA DECOMISADA'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'MERCANCÍA DECOMISADA PERDIDA O EXTRAVIADA'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEMANDAS JUDICIALES'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '06','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ESPECIES FISCALES'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '07','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ESPECIES FISCALES ENTREGADAS'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '08','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FONDOS Y VALORES EN CUSTODIA'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '08','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Fondos en custodia'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '08','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Valores en custodia'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '09','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INMUEBLES DADOS EN COMODATO'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '10','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RECLAMACIONES EN ESTUDIO'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '11','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'MERCANCÍAS RECIBIDAS EN CONSIGNACIÓN'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '12','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FIDEICOMISO'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '13','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INMUEBLES RECIBIDOS EN COMODATO'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '14','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TRIBUTOS COBRADOS EN EXCESO'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '15','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RAMOS DE INGRESOS DERECHOS LIQUIDADOS'
            ],
            [
                'group' => '4','subgroup' => '1','item' => '1', 'generic' => '16','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'EXONERACIONES DE INGRESOS'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CUENTAS DE ORDEN ACREEDORAS'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DIVERSAS'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'COMPROMISOS FUTUROS - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FINANZAS Y GARANTÍAS A FAVOR DE LA ENTIDAD - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Fondos en garantía'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Títulos y valores recibidos en garantía'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Documentos representativos de fianzas a favor de la entidad'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otras garantías a favor de la entidad'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'MERCANCÍA DECOMISADA - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'MERCANCÍA DECOMISADA PERDIDA O EXTRAVIADA - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEMANDAS JUDICIALES - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ESPECIES FISCALES - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '07','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ESPECIES FISCALES ENTREGADAS - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '08','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FONDOS Y VALORES EN CUSTODIA - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '08','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Fondos en custodia'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '08','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Valores en custodia'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '09','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INMUEBLES DADOS EN COMODATO - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '10','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RECLAMACIONES EN ESTUDIO - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '11','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'MERCANCÍAS RECIBIDAS EN CONSIGNACIÓN - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '12','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FIDEICOMISO - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '13','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INMUEBLES RECIBIDOS EN COMODATO - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '14','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TRIBUTOS COBRADOS EN EXCESO - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '15','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RAMOS DE INGRESOS DERECHOS LIQUIDADOS - CONTRA'
            ],
            [
                'group' => '4','subgroup' => '2','item' => '1', 'generic' => '16','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'EXONERACIONES DE TRIBUTOS - CONTRA'
            ],
            [
                'group' => '5','subgroup' => '0','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS ORDINARIOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS TRIBUTARIOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'IMPUESTOS DIRECTOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuesto sobre la renta'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuesto sobre sucesiones, donaciones y demás ramos conexos'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Reparos administrativos al impuesto sobre la renta'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Reparos administrativos al impuesto sobre sucesiones, donaciones y demás ramos conexos'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'IMPUESTOS INDIRECTOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuesto de importación'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuesto de exportación'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuesto sobre la producción, el consumo y transacciones financieras'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuestos a las actividades de juego de envite o azar'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Inmuebles urbanos'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '06','subspecific' => '00',
                'active' => true,
                'denomination' => 'Participación en el impuesto a la propiedad rural'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '07','subspecific' => '00',
                'active' => true,
                'denomination' => 'Patente de industria y comercio'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '08','subspecific' => '00',
                'active' => true,
                'denomination' => 'Patente de vehí culo'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '09','subspecific' => '00',
                'active' => true,
                'denomination' => 'Propaganda comercial'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '10','subspecific' => '00',
                'active' => true,
                'denomination' => 'Espectáculos públicos'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '11','subspecific' => '00',
                'active' => true,
                'denomination' => 'Apuestas lí citas'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '12','subspecific' => '00',
                'active' => true,
                'denomination' => 'Deudas morosas'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '13','subspecific' => '00',
                'active' => true,
                'denomination' => 'Reparos administrativos al impuesto de casinos, salas de juego y máquinas traganí queles'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otros impuestos indirectos'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TASAS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CONTRIBUCIONES ESPECIALES'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '04','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Contribuciones sobre la plusvalí a inmobiliaria'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '04','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Contribuciones por mejoras'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '1', 'generic' => '04','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otras contribuciones especiales'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '2', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'APORTES Y CONTRIBUCIONES A LA SEGURIDAD SOCIAL'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'APORTES A LA SEGURIDAD SOCIAL'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes del sector privado'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes del sector público'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CONTRIBUCIONES A LA SEGURIDAD SOCIAL'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Contribuciones del sector privado'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Contribuciones del sector público'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS NO TRIBUTARIOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS DEL DOMINIO PETROLERO'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Regalí as'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuesto superficial de hidrocarburos'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuesto de extracción'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuesto de registro de exportación'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Participación de Azufre'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '06','subspecific' => '00',
                'active' => true,
                'denomination' => 'Participación por Coque'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '07','subspecific' => '00',
                'active' => true,
                'denomination' => 'Ventajas especiales petroleras'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otros ingresos del dominio petrolero'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS DEL DOMINIO MINERO'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Superficial minero'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuesto de explotación'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '02','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Ventajas especiales mineras'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '02','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Regalía minera de oro'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS DEL DOMINIO FORESTAL'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuesto superficial'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuesto de explotación o aprovechamiento'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Permiso o autorización para la explotación o aprovechamiento de los recursos forestales'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Autorización para deforestación'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Autorización para movilizar productos forestales'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '06','subspecific' => '00',
                'active' => true,
                'denomination' => 'Participación por la explotación en zonas de reserva forestal'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '07','subspecific' => '00',
                'active' => true,
                'denomination' => 'Ventajas especiales por recursos forestales'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS SOBRE EL DOMINIO DE LA ACTIVIDAD TURÍSTICA'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '04','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Contribución especial por la prestación del servicio turístico'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '3', 'generic' => '04','specific' => '98','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otros ingresos percibidos por la explotación de la actividad turística'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '4', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'VENTA DE BIENES Y SERVICIOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'VENTA DE BIENES Y SERVICIOS DE LA ADMINISTRACIÓN PÚBLICA'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Ingresos por la venta de bienes'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Ingresos por la venta de servicios'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Ingresos por la venta de otros bienes y servicios'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '4', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS FINANCIEROS DE INSTITUCIONES FINANCIERAS BANCARIAS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '4', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS FINANCIEROS DE INSTITUCIONES FINANCIERAS NO BANCARIAS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '4', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS INGRESOS DE OPERACIÓN'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS DE LA PROPIEDAD'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INTERESES POR PRÉSTAMOS CONCEDIDOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses por préstamos concedidos al sector privado'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses por préstamos concedidos al sector público'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses por préstamos concedidos al sector externo'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INTERESES POR DEPÓSITOS EN INSTITUCIONES FINANCIERAS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses por depósitos a la vista'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses por depósitos a plazo fijo'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INTERESES DE TÍTULOS Y VALORES'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '03','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses de títulos y valores privados'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '03','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses de títulos y valores públicos'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '03','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses de títulos y valores externos'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '04','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de acciones y participaciones de capital del sector privado empresarial'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '04','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de acciones y participaciones de capital de entes descentralizados con fines empresariales petroleros'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '04','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de acciones y participaciones de capital de entes descentralizados con fines empresariales no petroleros'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '04','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de acciones y participaciones de capital de entes financieros bancarios'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '04','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de acciones y participaciones de capital de entes financieros no bancarios'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '04','specific' => '06','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de acciones y participaciones de capital de organismos internacionales'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '04','specific' => '07','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de acciones y participaciones de capital de otros entes del sector externo'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'UTILIDADES DE EXPLOTACIÓN DE JUEGOS DE AZAR'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '05','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de explotación de juegos de azar por concesiones'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '05','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de explotación de juegos de azar de empresas públicas'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '06','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ALQUILERES DE BIENES'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '06','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Alquileres de inmuebles'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '06','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Alquileres de bienes muebles'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '06','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Alquileres de otros bienes'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '07','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DERECHOS SOBRE BIENES INTANGIBLES'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '5', 'generic' => '09','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RENTA POR CONCESIONES DE BIENES Y SERVICIOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '6', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS AJENOS A LA OPERACIÓN'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '6', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SUBSIDIOS PARA PRECIOS Y TARIFAS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '6', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INCENTIVOS A LA EXPORTACIÓN'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '6', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS INGRESOS AJENOS A LA OPERACIÓN'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TRANSFERENCIAS Y DONACIONES'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TRANSFERENCIAS Y DONACIONES CORRIENTES'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Transferencias corrientes internas recibidas'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '01','specific' => '01','subspecific' => '01',
                'active' => true,
                'denomination' => 'Transferencias corrientes recibidas del sector privado'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '01','specific' => '01','subspecific' => '02',
                'active' => true,
                'denomination' => 'Transferencias corrientes recibidas del sector público'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '01','specific' => '01','subspecific' => '03',
                'active' => true,
                'denomination' => 'Transferencias corrientes recibidas del exterior'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '01','specific' => '01','subspecific' => '99',
                'active' => true,
                'denomination' => 'Otras transferencias corrientes recibidas del sector público'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Donaciones corrientes internas recibidas'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '01','specific' => '02','subspecific' => '01',
                'active' => true,
                'denomination' => 'Donaciones corrientes recibidas del sector privado'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '01','specific' => '02','subspecific' => '02',
                'active' => true,
                'denomination' => 'Donaciones corrientes recibidas del sector público'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '01','specific' => '02','subspecific' => '03',
                'active' => true,
                'denomination' => 'Donaciones corrientes recibidas del exterior'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SITUADO Y ASIGNACIONES A ESTADOS Y MUNICIPIOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Situado Constitucional'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '02','specific' => '01','subspecific' => '01',
                'active' => true,
                'denomination' => 'Situado Estadal'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '02','specific' => '01','subspecific' => '02',
                'active' => true,
                'denomination' => 'Situado Municipal'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Situado Estadal a Municipal'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SUBSIDIO DE RÉGIMEN ESPECIAL'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SUBSIDIO DE CAPITALIDAD'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '06','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes del sector público al Poder Estadal por transferencia de servicios'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '7', 'generic' => '06','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes del sector público al Poder Municipal por transferencia de servicios'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '8', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS INGRESOS ORDINARIOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '8', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INTERESES MORATORIOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '8', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'REPAROS FISCALES'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '8', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SANCIONES FISCALES'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '8', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'JUICIOS Y COSTAS PROCESALES'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '8', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'BENEFICIOS EN OPERACIONES CAMBIARÍAS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '8', 'generic' => '06','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'UTILIDAD POR VENTA DE ACTIVOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '8', 'generic' => '07','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INTERESES POR FINANCIAMIENTO DE DEUDAS TRIBUTARIAS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '8', 'generic' => '08','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'MULTAS Y RECARGOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '8', 'generic' => '09','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'REPAROS ADMINISTRATIVOS AL IMPUESTO A LOS ACTIVOS EMPRESARIALES'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '8', 'generic' => '10','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DIVERSOS REPAROS ADMINISTRATIVOS'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '8', 'generic' => '11','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS EN TRÁNSITO'
            ],
            [
                'group' => '5','subgroup' => '1','item' => '8', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS INGRESOS ORDINARIOS'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS EXTRAORDINARIOS'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS POR OPERACIONES DIVERSAS'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'LIQUIDACIÓN DE ENTES DESCENTRALIZADOS'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'HERENCIAS VACANTES'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PRIMA EN COLOCACIÓN DE TÍTULOS Y VALORES DE LA DEUDA PÚBLICA'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS PROVENIENTES DE PROCESOS DE LICITACIÓN'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'REINTEGRO DE FONDOS CORRESPONDIENTES A EJERCICIOS ANTERIORES'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Reintegro efectuado por exportadores proveniente de bonos de exportación'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Reintegro efectuado por organismos públicos proveniente de bonos de exportación'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Reintegro efectuado por los responsables del manejo o administración de fondos'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '03','subspecific' => '01',
                'active' => true,
                'denomination' => 'Reintegro de fondos correspondientes a ejercicios anteriores por gastos de personal'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '03','subspecific' => '02',
                'active' => true,
                'denomination' => 'Reintegro de fondos correspondientes a ejercicios anteriores por bienes y servicios'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '03','subspecific' => '03',
                'active' => true,
                'denomination' => 'Reintegro de fondos correspondientes a ejercicios anteriores por activos reales'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '03','subspecific' => '04',
                'active' => true,
                'denomination' => 'Reintegro de fondos correspondientes a ejercicios anteriores por activos financieros'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '03','subspecific' => '05',
                'active' => true,
                'denomination' => 'Reintegro de fondos correspondientes a ejercicios anteriores por gastos de defensa y seguridad del Estado'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '03','subspecific' => '06',
                'active' => true,
                'denomination' => 'Reintegro de fondos correspondientes a ejercicios anteriores por transferencias y donaciones'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '03','subspecific' => '07',
                'active' => true,
                'denomination' => 'Reintegro de fondos correspondientes a ejercicios anteriores por asignaciones no distribuidas y otros gastos'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '03','subspecific' => '08',
                'active' => true,
                'denomination' => 'Reintegro de fondos correspondientes a ejercicios anteriores por servicios de deuda pública'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '03','subspecific' => '09',
                'active' => true,
                'denomination' => 'Otros reintegros efectuados por los responsables del manejo de administración de fondos'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '06','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Reintegro efectuado por particulares'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '07','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INGRESOS POR DEVOLUCIONES O REINTEGROS INDEBIDOS'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '08','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'IMPUESTO A LAS TRANSACCIONES FINANCIERAS'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '08','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuesto a las transacciones financieras'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '08','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Reparos administrativos al impuesto a las transacciones financieras'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '08','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Multas y recargos por el impuesto a las transacciones financieras'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '09','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'UTILIDADES DE ACCIONES Y PARTICIPACIONES DE CAPITAL'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '09','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de acciones y participaciones de capital del sector privado empresarial'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '09','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de acciones y participaciones de capital de entes descentralizados con fines empresariales petroleros'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '09','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de acciones y participaciones de capital de entes descentralizados con fines empresariales no petroleros'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '09','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de acciones y participaciones de capital de entes financieros bancarios'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '09','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de acciones y participaciones de capital de entes financieros no bancarios'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '09','specific' => '06','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de acciones y participaciones de capital de organismos internacionales'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '09','specific' => '07','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades de acciones y participaciones de capital de otros entes del sector externo'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '09','specific' => '08','subspecific' => '00',
                'active' => true,
                'denomination' => 'Utilidades netas semestrales del Banco Central de Venezuela (BCV)'
            ],
            [
                'group' => '5','subgroup' => '2','item' => '1', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS INGRESOS EXTRAORDINARIOS'
            ],
            [
                'group' => '6','subgroup' => '0','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'GASTOS'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'GASTOS DE CONSUMO'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'GASTOS DE PERSONAL'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SUELDOS, SALARIOS Y OTRAS REMUNERACIONES'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '1', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'COMPLEMENTOS DE SUELDOS Y SALARIOS'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '1', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'APORTES PATRONALES Y LEGALES'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '1', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ASISTENCIA SOCIO ECONÓMICA'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '1', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PRESTACIONES SOCIALES E INDEMNIZACIONES'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '1', 'generic' => '06','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CAPACITACIÓN Y ADIESTRAMIENTO'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '1', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS GASTOS DE PERSONAL'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '2', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'MATERIALES, SUMINISTROS Y MERCANCÍAS'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'MATERIALES, SUMINISTROS Y MERCANCÍAS'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SERVICIOS NO PERSONALES'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ALQUILERES DE BIENES'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Alquileres de bienes inmuebles'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Alquileres de bienes muebles'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DERECHOS SOBRE BIENES INTANGIBLES'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SERVICIOS BÁSICOS'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Electricidad'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Gas'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Agua'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Teléfonos'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Servicio de comunicaciones'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '06','subspecific' => '00',
                'active' => true,
                'denomination' => 'Servicio de aseo urbano y domiciliario'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '03','specific' => '07','subspecific' => '00',
                'active' => true,
                'denomination' => 'Servicio de condominio'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SERVICIOS DE TRANSPORTE Y ALMACENAJE'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SERVICIOS DE INFORMACIÓN, IMPRESIÓN Y RELACIONES PÚBLICAS'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '06','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PRIMAS, GASTOS DE SEGUROS, COMISIONES Y GASTOS BANCARIOS'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '07','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'VIÁTICOS Y PASAJES'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '08','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SERVICIOS PROFESIONALES, TÉCNICOS Y DEMÁS OFICIOS Y OCUPACIONES'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '09','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CONSERVACIÓN Y REPARACIONES MENORES DE MAQUINARIA Y EQUIPOS'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '10','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CONSERVACIÓN Y REPARACIONES MENORES DE OBRAS'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '11','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SERVICIO DE ADMINISTRACIÓN, VIGILANCIA Y MANTENIMIENTO DE LOS SERVICIOS BÁSICOS'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '12','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SERVICIOS DE CONSTRUCCIONES TEMPORALES'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '13','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SERVICIOS DE CONSTRUCCIÓN DE EDIFICACIONES PARA LA VENTA'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '14','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SERVICIOS FISCALES'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '15','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SERVICIOS DE DIVERSIÓN, ESPARCIMIENTO Y CULTURALES'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '16','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SERVICIOS DE GESTIÓN ADMINISTRATIVA PRESTADOS POR ORGANISMOS DE ASISTENCIA TÉCNICA'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '17','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'IMPUESTOS INDIRECTOS'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '17','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuesto al valor agregado'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '17','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Impuesto a las grandes transacciones financieras'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '17','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otros impuestos indirectos'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '18','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'COMISIONES POR SERVICIOS PARA CUMPLIR CON LOS BENEFICIOS SOCIALES'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '3', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS SERVICIOS NO PERSONALES'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEPRECIACIÓN Y AMORTIZACIÓN'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DEPRECIACIÓN DE BIENES DE USO'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación de edificios e instalaciones'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación de maquinaria y demás equipos de construcción, campo, industria y taller'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación de equipos de transporte, tracción y elevación'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación de equipos de comunicaciones y señalamiento'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación de equipos médico-quirúrgicos, dentales y veterinarios'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '06','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación de equipos cientí ficos, religiosos, de enseñanza y recreación'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '07','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación de equipos y armamentos de orden público, seguridad y defensa'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '08','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación de máquinas, muebles y demás equipos de oficina y alojamiento'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '09','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación de semovientes'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '01','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Depreciación de otros bienes de uso'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'AMORTIZACIÓN DE ACTIVOS INTANGIBLES'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Amortización de marcas de fábrica y patentes de invención'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Amortización de derechos de autor'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '02','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Amortización de gastos de organización'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '02','specific' => '04','subspecific' => '00',
                'active' => true,
                'denomination' => 'Amortización de paquetes y programas de computación'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '02','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Amortización de estudios y proyectos'
            ],
            [
                'group' => '6','subgroup' => '1','item' => '4', 'generic' => '02','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Amortización de otros activos intangibles'
            ],
            [
                'group' => '6','subgroup' => '2','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RENTAS DE LA PROPIEDAD'
            ],
            [
                'group' => '6','subgroup' => '2','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INTERESES'
            ],
            [
                'group' => '6','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INTERESES INTERNOS'
            ],
            [
                'group' => '6','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses internos por títulos y valores'
            ],
            [
                'group' => '6','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses internos por préstamos'
            ],
            [
                'group' => '6','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses por depósitos internos'
            ],
            [
                'group' => '6','subgroup' => '2','item' => '1', 'generic' => '01','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses por otros financiamientos'
            ],
            [
                'group' => '6','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INTERESES EXTERNOS'
            ],
            [
                'group' => '6','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses externos por títulos y valores'
            ],
            [
                'group' => '6','subgroup' => '2','item' => '1', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Intereses externos por préstamos'
            ],
            [
                'group' => '6','subgroup' => '2','item' => '1', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INTERESES POR MORA Y MULTAS DE LA DEUDA PÚBLICA'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TRANSFERENCIAS'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TRANSFERENCIAS Y DONACIONES CORRIENTES'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TRANSFERENCIAS Y DONACIONES CORRIENTES OTORGADAS'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '1', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Transferencias corrientes internas otorgadas'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '1', 'generic' => '01','specific' => '01','subspecific' => '01',
                'active' => true,
                'denomination' => 'Transferencias corrientes otorgadas al sector privado'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '1', 'generic' => '01','specific' => '01','subspecific' => '02',
                'active' => true,
                'denomination' => 'Transferencias corrientes otorgadas al sector público'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '1', 'generic' => '01','specific' => '01','subspecific' => '03',
                'active' => true,
                'denomination' => 'Transferencias corrientes otorgadas al exterior'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '1', 'generic' => '01','specific' => '01','subspecific' => '99',
                'active' => true,
                'denomination' => 'Otras transferencias corrientes otorgadas al sector público'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Donaciones corrientes internas otorgadas'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '01',
                'active' => true,
                'denomination' => 'Donaciones corrientes otorgadas al sector privado'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '02',
                'active' => true,
                'denomination' => 'Donaciones corrientes otorgadas al sector público'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '03',
                'active' => true,
                'denomination' => 'Donaciones corrientes otorgadas al exterior'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SITUADO Y ASIGNACIONES A ESTADOS Y MUNICIPIOS'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SITUADO'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Situado Constitucional'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '01','specific' => '01','subspecific' => '01',
                'active' => true,
                'denomination' => 'Situado Estadal'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '01','specific' => '01','subspecific' => '02',
                'active' => true,
                'denomination' => 'Situado Municipal'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '01','specific' => '01','subspecific' => '03',
                'active' => true,
                'denomination' => 'Subsidio de régimen especial'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Situado Estadal a Municipal'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SUBSIDIO DE RÉGIMEN ESPECIAL'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'SUBSIDIO DE CAPITALIDAD'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'APORTES AL PODER ESTADAL Y MUNICIPAL POR TRANSFERENCIA DE SERVICIOS'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '04','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes al Poder Estadal por transferencia de servicios'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '04','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Aportes al Poder Municipal por transferencia de servicios'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'FONDO INTERGUBERNAMENTAL PARA LA DESCENTRALIZACIÓN'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '07','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'TRANSFERENCIAS Y DONACIONES A CONSEJOS COMUNALES'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '07','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Transferencias corrientes a Consejos Comunales'
            ],
            [
                'group' => '6','subgroup' => '3','item' => '2', 'generic' => '07','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Donaciones corrientes a Consejos Comunales'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PÉRDIDAS Y GASTOS DIVERSOS'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PÉRDIDAS EN OPERACIONES'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'GASTOS ORIGINADOS EN OBLIGACIONES DEL EJERCICIO'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '1', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Devoluciones de cobros indebidos'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '1', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Devoluciones y reintegros diversos'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '1', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Indemnizaciones diversas'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '1', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PÉRDIDA EN OPERACIÓN DE LOS SERVICIOS BÁSICOS'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '1', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Pérdida en el proceso de distribución de los servicios básicos'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '1', 'generic' => '02','specific' => '99','subspecific' => '00',
                'active' => true,
                'denomination' => 'Otras pérdidas en operación'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '2', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PÉRDIDAS AJENAS A LA OPERACIÓN'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '2', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PÉRDIDAS EN INVENTARIOS'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '2', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PÉRDIDAS EN OPERACIONES CAMBIARÍAS'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '2', 'generic' => '03','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PÉRDIDAS EN VENTAS DE ACTIVOS'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '2', 'generic' => '04','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PÉRDIDAS POR CUENTAS INCOBRABLES'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '2', 'generic' => '05','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PARTICIPACIÓN EN PÉRDIDAS DE OTRAS EMPRESAS'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '2', 'generic' => '06','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'PÉRDIDAS POR AUTO-SEGURO'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '2', 'generic' => '07','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'IMPUESTOS DIRECTOS'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '2', 'generic' => '08','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INTERESES POR MORA'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '2', 'generic' => '09','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RESERVAS TÉCNICAS'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '3', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'GASTOS DIVERSOS'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '3', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DESCUENTOS, BONIFICACIONES Y DEVOLUCIONES'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '3', 'generic' => '01','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Descuentos sobre ventas'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '3', 'generic' => '01','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Bonificaciones por ventas'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '3', 'generic' => '01','specific' => '03','subspecific' => '00',
                'active' => true,
                'denomination' => 'Devoluciones por ventas'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '3', 'generic' => '01','specific' => '05','subspecific' => '00',
                'active' => true,
                'denomination' => 'Descuentos en colocación de títulos, letras y otros valores de la deuda pública'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '3', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'INDEMNIZACIONES Y SANCIONES PECUNIARIAS'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '3', 'generic' => '02','specific' => '01','subspecific' => '00',
                'active' => true,
                'denomination' => 'Indemnizaciones pecuniarias por daños y perjuicios'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '3', 'generic' => '02','specific' => '02','subspecific' => '00',
                'active' => true,
                'denomination' => 'Sanciones pecuniarias'
            ],
            [
                'group' => '6','subgroup' => '4','item' => '3', 'generic' => '99','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'OTROS GASTOS'
            ],
            [
                'group' => '6','subgroup' => '5','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'GASTOS DE DEFENSA Y SEGURIDAD DEL ESTADO Y ASIGNACIONES NO DISTRIBUIDAS'
            ],
            [
                'group' => '6','subgroup' => '5','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'GASTOS DE DEFENSA Y SEGURIDAD DEL ESTADO'
            ],
            [
                'group' => '6','subgroup' => '5','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'GASTOS DE DEFENSA Y SEGURIDAD DEL ESTADO'
            ],
            [
                'group' => '6','subgroup' => '5','item' => '2', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ASIGNACIONES NO DISTRIBUIDAS'
            ],
            [
                'group' => '6','subgroup' => '5','item' => '2', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'ASIGNACIONES NO DISTRIBUIDAS'
            ],
            [
                'group' => '7','subgroup' => '0','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CUENTAS DE CIERRE'
            ],
            [
                'group' => '7','subgroup' => '1','item' => '0', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'CIERRE DEL EJERCICIO ECONÓMICO FINANCIERO'
            ],
            [
                'group' => '7','subgroup' => '1','item' => '1', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RESUMEN DE INGRESOS Y GASTOS'
            ],
            [
                'group' => '7','subgroup' => '1','item' => '1', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RESUMEN DE INGRESOS Y GASTOS'
            ],
            [
                'group' => '7','subgroup' => '1','item' => '2', 'generic' => '00','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'RESULTADO DE LA GESTIÓN'
            ],
            [
                'group' => '7','subgroup' => '1','item' => '2', 'generic' => '01','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'AHORRO DE LA GESTIÓN'
            ],
            [
                'group' => '7','subgroup' => '1','item' => '2', 'generic' => '02','specific' => '00','subspecific' => '00',
                'active' => true,
                'denomination' => 'DESAHORRO DE LA GESTIÓN'
            ],
        ];

        DB::transaction(function() use ($accounting_acounts) {
            foreach ($accounting_acounts as $account) {

                /** @var Object que almacena la consulta de la cuenta, si esta no existe retorna null */
                $acc = AccountingAccount::where('group',$account['group'])
                                    ->where('subgroup',$account['subgroup'])
                                    ->where('item',$account['item'])
                                    ->where('generic',$account['generic'])
                                    ->where('specific',$account['specific'])
                                    ->where('subspecific',$account['subspecific'])->first();

                /** @var Object que almacena la consulta de la cuenta de nivel superior de la cuanta actual, si esta no posee retorna false */
                $parent = AccountingAccount::getParent(
                        $account['group'], $account['subgroup'], $account['item'], $account['generic'], $account['specific'], $account['subspecific']
                    );

                AccountingAccount::updateOrCreate(
                    [
                        'group' => $account['group'], 'subgroup' => $account['subgroup'],
                        'item' => $account['item'], 'generic' => $account['generic'],
                        'specific' => $account['specific'], 'subspecific' => $account['subspecific']
                    ],[
                        'denomination' => $account['denomination'],
                        'active' => $account['active'],
                        'inactivity_date' => (!$account['active'])?date('Y-m-d'):null,

                        /**
                        * Si existe, al ejecutar nuevamente el seeder o refrescar la base de datos evita que se asigne en la columna parent_id a si mismo como su parent
                        */ 
                        'parent_id' => ($acc != null) ? (($acc->id == $parent->id)?null:$parent->id) : (($parent == false)?null:$parent->id) ,
                    ]
                );
            }
        });
    }
}
