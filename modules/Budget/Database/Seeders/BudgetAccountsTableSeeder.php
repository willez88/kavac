<?php

namespace Modules\Budget\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Budget\Models\BudgetAccount;

/**
 * @class BudgetAccountsTableSeeder
 * @brief Información por defecto para cuentas presupuestarias
 *
 * Gestiona la información por defecto a registrar inicialmente para las cuentas presupuestarias
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class BudgetAccountsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $budget_accounts = [
            [
                'group' => '3', 'item' => '00', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'RECURSOS',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'INGRESOS ORDINARIOS',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Impuestos directos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Impuesto sobre la renta a personas jurí­dicas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Impuesto a empresas de hidrocarburos privadas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Impuesto a empresas de hidrocarburos públicas -operadoras y comercializadoras',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Impuesto a empresas de hidrocarburos públicas -Petróleos de Venezuela, ' .
                                  'S.A Casa matriz y otras filiales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Impuesto adicional a empresas de hidrocarburos privadas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '01', 'subspecific' => '05',
                'denomination' => 'Impuesto adicional a empresas de hidrocarburos  públicas -operadoras y ' .
                                  'comercializadoras',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '01', 'subspecific' => '06',
                'denomination' => 'Impuesto adicional a empresas de hidrocarburos  públicas -otras filiales de ' .
                                  'Petróleos de Venezuela, S.A. (PDVSA)',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '01', 'subspecific' => '07',
                'denomination' => 'Impuesto a empresas mineras sector hierro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '01', 'subspecific' => '08',
                'denomination' => 'Impuesto a empresas mineras sector otros minerales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '01', 'subspecific' => '09',
                'denomination' => 'Impuesto adicional a empresas mineras sector hierro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '01', 'subspecific' => '10',
                'denomination' => 'Impuesto adicional a empresas mineras sector otros minerales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '01', 'subspecific' => '11',
                'denomination' => 'Impuesto sobre la renta a otras personas jurí­dicas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Impuesto sobre la renta a personas naturales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Impuestos sobre sucesiones, donaciones y demás ramos conexos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Reparos administrativos por impuesto sobre la renta a personas jurídicas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '04', 'subspecific' => '01',
                'denomination' => 'Reparos administrativos por impuesto a empresas de hidrocarburos privadas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '04', 'subspecific' => '02',
                'denomination' => 'Reparos administrativos a empresas de hidrocarburos públicas -operadoras y ' .
                                  'comercializadoras',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '04', 'subspecific' => '03',
                'denomination' => 'Reparos administrativos a empresas de hidrocarburos  públicas -otras filiales ' .
                                  'de Petróleos de Venezuela, S.A (PDVSA)',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '04', 'subspecific' => '04',
                'denomination' => 'Reparos administrativos a empresas mineras sector hierro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '04', 'subspecific' => '05',
                'denomination' => 'Reparos administrativos a empresas mineras sector otros minerales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '04', 'subspecific' => '06',
                'denomination' => 'Reparos administrativos a otras personas jurí­dicas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Reparos administrativos por impuesto sobre la renta a personas naturales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '01', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Reparos administrativos a impuesto sobre sucesiones, ' .
                                  'donaciones y demás ramos conexos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Impuestos indirectos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Impuestos de importación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Impuesto de importación ordinario',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Impuesto de importación de bultos postales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Impuesto interno por la importación de alcoholes y bebidas alcohólicas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Impuesto de exportación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Impuesto sobre la producción, el consumo y transacciones financieras',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Impuesto sobre alcoholes de producción nacional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Impuesto sobre bebidas alcohólicas de producción nacional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '03',
                'denomination' => 'Impuesto sobre cerveza de producción nacional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '04',
                'denomination' => 'Impuesto sobre vinos de producción nacional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '05',
                'denomination' => 'Impuesto sobre el precio de venta al público de las cervezas y vinos naturales ' .
                                  'de producción nacional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '06',
                'denomination' => 'Impuesto sobre el precio de venta al público de las cervezas y ' .
                                  'vinos naturales importados',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '07',
                'denomination' => 'Impuesto sobre el precio de venta al público de otras bebidas hasta 50.0° G.L. ' .
                                  'de producción nacional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '08',
                'denomination' => 'Impuesto sobre el precio de venta al público de otras bebidas ' .
                                  'hasta 50.0° G.L. importadas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '09',
                'denomination' => 'Impuesto sobre expedición al público de especies alcohólicas importadas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '10',
                'denomination' => 'Impuesto sobre expedición al público de especies alcohólicas nacionales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '11',
                'denomination' => 'Impuesto sobre la venta de cigarrillos, tabacos y picaduras importadas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '12',
                'denomination' => 'Impuesto sobre la venta de cigarrillos, tabacos y picaduras de producción nacional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '13',
                'denomination' => 'Impuesto a la producción de fósforos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '14',
                'denomination' => 'Ventajas especiales por fabricación de fósforos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '15',
                'denomination' => 'Impuesto al consumo propio de gasolina',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '16',
                'denomination' => 'Impuesto al consumo general a la gasolina',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '17',
                'denomination' => 'Impuesto al consumo propio de otros derivados del petróleo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '18',
                'denomination' => 'Impuesto al consumo general de otros derivados del petróleo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '19',
                'denomination' => 'Impuesto sobre telecomunicaciones',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '20',
                'denomination' => 'Impuesto al valor agregado sobre la importación de bienes y servicios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '21',
                'denomination' => 'Impuesto al valor agregado sobre la producción, distribución y comercialización ' .
                                  'de bienes y servicios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '22',
                'denomination' => 'Impuesto al valor agregado sobre los hechos imponibles realizados por empresas ' .
                                  'públicas, institutos autónomos y demás entes descentralizados',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '23',
                'denomination' => 'Reparos administrativos a impuestos al valor agregado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '24',
                'denomination' => 'Impuesto al débito bancario',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '25',
                'denomination' => 'Reparos administrativos al impuesto al débito bancario',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Impuestos a las actividades de juegos de envite o azar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '04', 'subspecific' => '01',
                'denomination' => 'Impuestos sobre casinos y salas de bingo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '04', 'subspecific' => '02',
                'denomination' => 'Impuestos de explotación de mesas de juego y máquinas traganíqueles',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '04', 'subspecific' => '03',
                'denomination' => 'Reparos administrativos impuesto casinos, salas de juego y máquinas traganí­queles',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Inmuebles urbanos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Participación en el impuesto a la propiedad rural',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Patente de industria y comercio',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Patente de vehí­culo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Propaganda comercial',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '10', 'subspecific' => '00',
                'denomination' => 'Espectáculos públicos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '11', 'subspecific' => '00',
                'denomination' => 'Apuestas lí­citas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '12', 'subspecific' => '00',
                'denomination' => 'Deudas morosas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros impuestos indirectos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ingresos por tasas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Derechos de tránsito terrestre',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Derechos a examen',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Derechos de expedición, renovación y reválida de licencias',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Derechos de registro y traspaso',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Derechos de placas identificadoras',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Derechos por revisión anual',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Derechos por remoción o arrastre de vehí­culos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Derechos por estacionamiento de vehículos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Permiso para uso de rutas extraurbanas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '10', 'subspecific' => '00',
                'denomination' => 'Copias de documentos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '11', 'subspecific' => '00',
                'denomination' => 'Tasas para el uso de aeronaves y por licencias de personal aeronáutico',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '12', 'subspecific' => '00',
                'denomination' => 'Tasas aeroportuarias',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '13', 'subspecific' => '00',
                'denomination' => 'Tasas por uso de canales de navegación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '14', 'subspecific' => '00',
                'denomination' => 'Patente de navegación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '15', 'subspecific' => '00',
                'denomination' => 'Expedición de licencias de navegación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '16', 'subspecific' => '00',
                'denomination' => 'Servicio de telecomunicaciones',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '17', 'subspecific' => '00',
                'denomination' => 'Permisos para estaciones privadas de radiocomunicaciones',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '18', 'subspecific' => '00',
                'denomination' => 'Derechos de pilotajes',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '19', 'subspecific' => '00',
                'denomination' => 'Habilitación de pilotaje',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '20', 'subspecific' => '00',
                'denomination' => 'Servicios de remolcadores',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '21', 'subspecific' => '00',
                'denomination' => 'Habilitación de remolcadores',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '22', 'subspecific' => '00',
                'denomination' => 'Habilitación de capitaní­as de puerto',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '23', 'subspecific' => '00',
                'denomination' => 'Otros servicios de capitaní­as de puerto',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '24', 'subspecific' => '00',
                'denomination' => 'Tasas de faros y boyas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '25', 'subspecific' => '00',
                'denomination' => 'Servicios de aduana',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '26', 'subspecific' => '00',
                'denomination' => 'Habilitación de aduanas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '27', 'subspecific' => '00',
                'denomination' => 'Derechos de almacenaje',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '28', 'subspecific' => '00',
                'denomination' => 'Corretaje de bultos postales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '29', 'subspecific' => '00',
                'denomination' => 'Servicios de consulta sobre clasificación arancelaria, valoración aduanera y ' .
                                  'análisis de laboratorio',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '30', 'subspecific' => '00',
                'denomination' => 'Bandas de garantí­a, cápsulas y sellos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '31', 'subspecific' => '00',
                'denomination' => 'Servicio de peaje',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '32', 'subspecific' => '00',
                'denomination' => 'Servicio de riego y drenaje',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '33', 'subspecific' => '00',
                'denomination' => 'Estampillas fiscales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '34', 'subspecific' => '00',
                'denomination' => 'Papel sellado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '35', 'subspecific' => '00',
                'denomination' => 'Derechos de traslado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '36', 'subspecific' => '00',
                'denomination' => 'Servicios sanitarios marí­timos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '37', 'subspecific' => '00',
                'denomination' => 'Servicios hospitalarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '38', 'subspecific' => '00',
                'denomination' => 'Venta de copias de planos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '39', 'subspecific' => '00',
                'denomination' => 'Derechos de contraste, verificación y estudios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '40', 'subspecific' => '00',
                'denomination' => 'Patente de pesca de perlas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '41', 'subspecific' => '00',
                'denomination' => 'Licencia de caza',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '42', 'subspecific' => '00',
                'denomination' => 'Derechos de cancillerí­a',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '43', 'subspecific' => '00',
                'denomination' => 'Depósitos por el ingreso al paí­s de extranjeros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '44', 'subspecific' => '00',
                'denomination' => 'Registro sanitario',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '45', 'subspecific' => '00',
                'denomination' => 'Derechos de análisis de sustancias quí­micas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '46', 'subspecific' => '00',
                'denomination' => 'Derechos consulares',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '47', 'subspecific' => '00',
                'denomination' => 'Matrí­cula para importar y exportar sustancias estupefacientes y psicotrópicas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '48', 'subspecific' => '00',
                'denomination' => 'Permisos municipales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '49', 'subspecific' => '00',
                'denomination' => 'Certificaciones y solvencias',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '50', 'subspecific' => '00',
                'denomination' => 'Servicio de energí­a eléctrica',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '51', 'subspecific' => '00',
                'denomination' => 'Servicio de distribución de agua',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '52', 'subspecific' => '00',
                'denomination' => 'Servicio de gas doméstico',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '53', 'subspecific' => '00',
                'denomination' => 'Mensura y deslinde',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '54', 'subspecific' => '00',
                'denomination' => 'Aseo domiciliario',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '55', 'subspecific' => '00',
                'denomination' => 'Matadero',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '56', 'subspecific' => '00',
                'denomination' => 'Mercado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '57', 'subspecific' => '00',
                'denomination' => 'Cementerio',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '58', 'subspecific' => '00',
                'denomination' => 'Terminal de pasajeros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '59', 'subspecific' => '00',
                'denomination' => 'Deudas morosas por tasas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '03', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros tipos de tasas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ingresos por contribuciones especiales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Sobre la plusvalí­a inmobiliaria',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Contribuciones por mejoras',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '04', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otras contribuciones especiales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ingresos por aportes y contribuciones a la seguridad social',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Ingresos por aportes patronales a la seguridad social',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '05', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Ingresos por aportes del sector privado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '05', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Ingresos por aportes del sector público',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '05', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Contribuciones personales a la seguridad social',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '05', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Contribuciones del sector privado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '05', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Contribuciones del sector público',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ingresos del dominio petrolero',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Regalías',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '06', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Impuesto superficial de hidrocarburos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '06', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros ingresos del dominio petrolero',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '06', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Regalí­as petroleras privadas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '06', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Regalí­as petroleras públicas - crudos y condensados',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '06', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Regalí­as petroleras públicas - extrapesado para orimulsión',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '06', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Regalí­as del gas empresas privadas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '06', 'specific' => '01', 'subspecific' => '05',
                'denomination' => 'Regalías del gas empresas públicas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '06', 'subspecific' => '09',
                'denomination' => 'Utilidades netas semestrales Banco Central de Venezuela (BCV)',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '07', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ingresos del dominio minero',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '07', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Superficial minero',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '07', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Superficial sobre hierro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '07', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Superficial sobre oro y diamante',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '07', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Superficial sobre otros minerales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '07', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Impuesto de explotación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '07', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Impuesto de explotación sobre hierro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '07', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Impuesto de explotación sobre oro, plata, platino y otros metales asociados a ' .
                                  'este último',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '07', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Impuesto de explotación sobre diamante y demás piedras preciosas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '07', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Impuesto de explotación sobre otros minerales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '07', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Ventajas especiales mineras',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '08', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ingresos del dominio forestal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '08', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Impuesto superficial',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '08', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Impuesto de explotación o aprovechamiento',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '08', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Permiso o autorización para la explotación o aprovechamiento de los productos ' .
                                  'forestales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '08', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Autorización para deforestación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '08', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Autorización para movilizar productos forestales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '08', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Participación por la explotación en zonas de reserva forestal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '08', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Ventajas especiales por recursos forestales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '09', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ingresos por la venta de bienes y servicios de la administración pública',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '09', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Ingresos por la venta de bienes',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '09', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Ingresos por la venta de gacetas municipales y formularios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '09', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Ingresos por la venta de publicaciones oficiales y formularios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '09', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Ingresos por la venta de servicios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '09', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Ingresos por la venta de productos de loterí­a',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '09', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Ingresos por la venta de otros bienes y servicios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ingresos de la propiedad',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Intereses por préstamos concedidos al sector privado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Intereses por préstamos concedidos al sector público',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Intereses por préstamos concedidos a la República',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Intereses por préstamos concedidos a entes descentralizados sin fines empresariales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Intereses por préstamos concedidos a instituciones de protección social',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Intereses por préstamos concedidos a entes descentralizados con fines ' .
                                  'empresariales petroleros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '02', 'subspecific' => '05',
                'denomination' => 'Intereses por préstamos concedidos a entes descentralizados con fines ' .
                                  'empresariales no petroleros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '02', 'subspecific' => '06',
                'denomination' => 'Intereses por préstamos concedidos a entes descentralizados financieros bancarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '02', 'subspecific' => '07',
                'denomination' => 'Intereses por préstamos concedidos a entes descentralizados ' .
                                  'financieros no bancarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '02', 'subspecific' => '08',
                'denomination' => 'Intereses por préstamos concedidos al Poder Estadal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '02', 'subspecific' => '09',
                'denomination' => 'Intereses por préstamos concedidos al Poder Municipal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Intereses por préstamos concedidos al sector externo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Intereses por depósitos en instituciones financieras',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '04', 'subspecific' => '01',
                'denomination' => 'Intereses por depósitos a la vista',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '04', 'subspecific' => '02',
                'denomination' => 'Intereses por depósitos a plazo fijo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Intereses de títulos y valores',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '05', 'subspecific' => '01',
                'denomination' => 'Intereses de tí­tulos y valores privados',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '05', 'subspecific' => '02',
                'denomination' => 'Intereses de tí­tulos y valores públicos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '05', 'subspecific' => '03',
                'denomination' => 'Intereses de tí­tulos y valores externos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Utilidades  de acciones y participaciones de capital',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '06', 'subspecific' => '01',
                'denomination' => 'Utilidades de acciones y participaciones de capital del sector privado empresarial',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '06', 'subspecific' => '02',
                'denomination' => 'Utilidades de acciones y participaciones de capital de entes descentralizados con ' .
                                  'fines empresariales petroleros - dividendos de Petróleos de Venezuela, S.A (PDVSA)',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '06', 'subspecific' => '03',
                'denomination' => 'Utilidades de acciones y participaciones de capital de entes descentralizados con ' .
                                  'fines empresariales petroleros - otras empresas petroleras',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '06', 'subspecific' => '04',
                'denomination' => 'Utilidades de acciones y participaciones de capital de entes descentralizados con ' .
                                  'fines empresariales no petroleros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '06', 'subspecific' => '05',
                'denomination' => 'Utilidades de acciones y participaciones de capital de entes descentralizados ' .
                                  'financieros bancarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '06', 'subspecific' => '06',
                'denomination' => 'Utilidades de acciones y participaciones de capital de entes descentralizados ' .
                                  'financieros no bancarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '06', 'subspecific' => '07',
                'denomination' => 'Utilidades de acciones y participaciones de capital de organismos internacionales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '06', 'subspecific' => '08',
                'denomination' => 'Utilidades de acciones y participaciones de capital de otros entes ' .
                                  'del sector externo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Utilidades de explotación de juegos de azar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '07', 'subspecific' => '01',
                'denomination' => 'Utilidades de explotación de juegos de azar por concesiones',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '07', 'subspecific' => '02',
                'denomination' => 'Utilidades de explotación de juegos de azar de empresas públicas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Alquileres',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '08', 'subspecific' => '01',
                'denomination' => 'Alquileres de edificios y locales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '08', 'subspecific' => '02',
                'denomination' => 'Alquileres de tierras y terrenos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '08', 'subspecific' => '03',
                'denomination' => 'Alquileres de instalaciones culturales y recreativas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '08', 'subspecific' => '04',
                'denomination' => 'Alquileres de máquinas y demás equipos de construcción, campo, industria y taller',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '08', 'subspecific' => '05',
                'denomination' => 'Alquileres de equipos de transporte, tracción y elevación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '08', 'subspecific' => '06',
                'denomination' => 'Alquileres de equipos de telecomunicaciones y señalamiento',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '08', 'subspecific' => '07',
                'denomination' => 'Alquileres de equipos médico - quirúrgicos, dentales y de veterinaria',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '08', 'subspecific' => '08',
                'denomination' => 'Alquileres de equipos cientí­ficos, de enseñanza y recreación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '08', 'subspecific' => '09',
                'denomination' => 'Alquileres de máquinas, muebles y demás equipos de oficina y alojamiento',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '08', 'subspecific' => '99',
                'denomination' => 'Alquileres de otros bienes',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Derechos sobre bienes intangibles',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '09', 'subspecific' => '01',
                'denomination' => 'Marcas de fábrica y patentes de invención',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '09', 'subspecific' => '02',
                'denomination' => 'Derechos de autor',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '09', 'subspecific' => '03',
                'denomination' => 'Paquetes y programas de computación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '10', 'specific' => '10', 'subspecific' => '00',
                'denomination' => 'Concesiones de bienes y servicios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Diversos ingresos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Intereses moratorios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Reparos fiscales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Sanciones fiscales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Juicios y costas procesales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '04', 'subspecific' => '01',
                'denomination' => 'Ingresos por el principal en sentencias judiciales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '04', 'subspecific' => '02',
                'denomination' => 'Costas procesales varias',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '04', 'subspecific' => '03',
                'denomination' => 'Responsabilidad fiscal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '04', 'subspecific' => '04',
                'denomination' => 'Otras disposiciones legales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '04', 'subspecific' => '05',
                'denomination' => 'Indemnización por incumplimiento de contratos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '04', 'subspecific' => '06',
                'denomination' => 'Juicios y costas procesales por impuesto sobre la renta',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Beneficios en operaciones cambiarias',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Utilidad por venta de activos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Intereses por financiamiento de deudas tributarias',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Multas y recargos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Reparos administrativos al impuesto a los activos empresariales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '10', 'subspecific' => '00',
                'denomination' => 'Diversos reparos administrativos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '11', 'specific' => '11', 'subspecific' => '00',
                'denomination' => 'Ingresos en tránsito',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '99', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Otros ingresos ordinarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '99', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Otros ingresos ordinarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'INGRESOS EXTRAORDINARIOS',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Endeudamiento público interno',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Colocación de títulos y valores de deuda pública interna a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Colocación de bonos a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Colocación de letras del tesoro a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Obtención de préstamos internos a corto plazo ',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Obtención de préstamos del sector privado a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Obtención de préstamos de la República a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Obtención de préstamos de los entes descentralizados sin fines empresariales a ' .
                                  'corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Obtención de préstamos de las instituciones de protección social a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '02', 'subspecific' => '05',
                'denomination' => 'Obtención de préstamos de los entes descentralizados con fines empresariales ' .
                                  'petroleros a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '02', 'subspecific' => '06',
                'denomination' => 'Obtención de préstamos de los entes descentralizados con fines empresariales ' .
                                  'no petroleros a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '02', 'subspecific' => '07',
                'denomination' => 'Obtención de préstamos de entes descentralizados financieros bancarios ' .
                                  'a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '02', 'subspecific' => '08',
                'denomination' => 'Obtención de préstamos de entes descentralizados financieros no bancarios a corto ' .
                                  'plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '02', 'subspecific' => '09',
                'denomination' => 'Obtención de préstamos del Poder Estadal a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '02', 'subspecific' => '10',
                'denomination' => 'Obtención de préstamos del Poder Municipal a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Colocación de títulos y valores de la deuda pública interna a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Colocación de bonos a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Colocación de letras del tesoro a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Obtención de préstamos internos a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '04', 'subspecific' => '01',
                'denomination' => 'Obtención de préstamos del sector privado a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '04', 'subspecific' => '02',
                'denomination' => 'Obtención de préstamos de la República a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '04', 'subspecific' => '03',
                'denomination' => 'Obtención de préstamos de los entes descentralizados sin fines empresariales a ' .
                                  'largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '04', 'subspecific' => '04',
                'denomination' => 'Obtención de préstamos de las instituciones de protección social a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '04', 'subspecific' => '05',
                'denomination' => 'Obtención de préstamos de los entes descentralizados con fines empresariales ' .
                                  'petroleros a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '04', 'subspecific' => '06',
                'denomination' => 'Obtención de préstamos de los entes descentralizados con fines empresariales no ' .
                                  'petroleros a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '04', 'subspecific' => '07',
                'denomination' => 'Obtención de préstamos de entes descentralizados financieros bancarios ' .
                                  'a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '04', 'subspecific' => '08',
                'denomination' => 'Obtención de préstamos de entes descentralizados financieros no bancarios a largo ' .
                                  'plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '04', 'subspecific' => '09',
                'denomination' => 'Obtención de préstamos del Poder Estadal a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '01', 'specific' => '04', 'subspecific' => '10',
                'denomination' => 'Obtención de préstamos del Poder Municipal a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Endeudamiento público externo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Colocación de títulos y valores de la deuda pública externa a corto plazo ',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Obtención de préstamos externos a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '02', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Obtención de préstamos de gobiernos extranjeros a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '02', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Obtención de préstamos de organismos internacionales a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '02', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Obtención de préstamos de instituciones financieras externas a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '02', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Obtención de préstamos de proveedores de bienes y servicios externos a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Colocación de tí­tulos y valores de la deuda pública externa a largo plazo ',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '02', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Obtención de préstamos externos a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '02', 'specific' => '04', 'subspecific' => '01',
                'denomination' => 'Obtención de préstamos de gobiernos extranjeros a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '02', 'specific' => '04', 'subspecific' => '02',
                'denomination' => 'Obtención de préstamos de organismos internacionales a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '02', 'specific' => '04', 'subspecific' => '03',
                'denomination' => 'Obtención de préstamos de instituciones financieras externas a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '02', 'specific' => '04', 'subspecific' => '04',
                'denomination' => 'Obtención de préstamos de proveedores de bienes y servicios externos a largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ingresos por operaciones diversas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Liquidación de entes descentralizados',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Herencias vacantes y donaciones',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '03', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Prima en colocación de títulos y valores de la deuda pública',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Impuesto a las transacciones financieras',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '03', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Ingresos por procesos licitatorios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '03', 'specific' => '05', 'subspecific' => '01',
                'denomination' => 'Cuotas por participación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '03', 'specific' => '05', 'subspecific' => '02',
                'denomination' => 'Bonos de desempate',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '03', 'specific' => '05', 'subspecific' => '99',
                'denomination' => 'Otros ingresos por procesos licitatorios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Reintegro de fondos correspondientes a ejercicios anteriores',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Reintegro proveniente de bonos de exportación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Reintegro de fondos efectuado por organismos públicos proveniente de bonos de ' .
                                  'exportación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ingresos por obtención indebida de devoluciones o reintegros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Ingresos por obtención indebida de devoluciones o reintegros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '99', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Otros ingresos extraordinarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '99', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Otros ingresos extraordinarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'INGRESOS DE OPERACIÓN',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Venta bruta de bienes',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Venta de productos del sector industrial',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Venta de productos del sector comercial',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Venta bruta de servicios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Venta bruta de servicios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ingresos financieros de instituciones financieras bancarias',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Ingresos por inversiones en valores',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Ingresos por cartera de créditos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '03', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Ingresos provenientes de la administración de fideicomisos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '03', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros ingresos financieros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ingresos financieros de instituciones financieras no bancarias',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Ingresos por inversiones en valores',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Ingresos por cartera de créditos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '04', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Ingresos provenientes de la administración de fideicomisos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '04', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros ingresos financieros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ingresos por operaciones de seguro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Ingresos por operaciones de primas de seguro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '05', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Ingresos por operaciones de reaseguro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '05', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Ingresos por salvamento de siniestros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '05', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros ingresos por operaciones de seguro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '99', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Otros ingresos de operación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '03', 'generic' => '99', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Otros ingresos de operación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '04', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'INGRESOS AJENOS A LA OPERACIÓN',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '04', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Subsidios para precios y tarifas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '04', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Subsidios para precios y tarifas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '04', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incentivos a la exportación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '04', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incentivos a la exportación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '04', 'generic' => '99', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Otros ingresos ajenos a la operación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '04', 'generic' => '99', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Otros ingresos ajenos a la operación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'TRANSFERENCIAS Y DONACIONES',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Transferencias y donaciones corrientes',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Transferencias corrientes internas del sector privado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Transferencias corrientes internas de personas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Transferencias corrientes internas de instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Transferencias corrientes internas de empresas privadas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Donaciones corrientes internas del sector privado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Donaciones corrientes internas de personas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Donaciones corrientes internas de instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Donaciones corrientes internas de empresas privadas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Transferencias corrientes internas del sector público',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Transferencias corrientes internas de la República',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Transferencias corrientes internas de entes descentralizados ' .
                                  'sin fines empresariales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '03', 'subspecific' => '03',
                'denomination' => 'Transferencias corrientes internas de instituciones de protección social',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '03', 'subspecific' => '04',
                'denomination' => 'Transferencias corrientes internas de entes descentralizados con fines ' .
                                  'empresariales petroleros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '03', 'subspecific' => '05',
                'denomination' => 'Transferencias corrientes internas de entes descentralizados con fines ' .
                                  'empresariales no petroleros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '03', 'subspecific' => '06',
                'denomination' => 'Transferencias corrientes internas de entes descentralizados financieros bancarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '03', 'subspecific' => '07',
                'denomination' => 'Transferencias corrientes internas de entes descentralizados ' .
                                  'financieros no bancarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '03', 'subspecific' => '08',
                'denomination' => 'Transferencias corrientes internas del Poder Estadal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '03', 'subspecific' => '09',
                'denomination' => 'Transferencias corrientes internas del Poder Municipal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Donaciones corrientes internas del sector público',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '04', 'subspecific' => '01',
                'denomination' => 'Donaciones corrientes internas de la República',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '04', 'subspecific' => '02',
                'denomination' => 'Donaciones corrientes internas de entes descentralizados sin fines empresariales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '04', 'subspecific' => '03',
                'denomination' => 'Donaciones corrientes internas de instituciones de protección social',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '04', 'subspecific' => '04',
                'denomination' => 'Donaciones corrientes internas de entes descentralizados con fines ' .
                                  'empresariales petroleros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '04', 'subspecific' => '05',
                'denomination' => 'Donaciones corrientes internas de entes descentralizados con fines ' .
                                  'empresariales no petroleros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '04', 'subspecific' => '06',
                'denomination' => 'Donaciones corrientes internas de entes descentralizados financieros bancarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '04', 'subspecific' => '07',
                'denomination' => 'Donaciones corrientes internas de entes descentralizados financieros no bancarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '04', 'subspecific' => '08',
                'denomination' => 'Donaciones corrientes internas del Poder Estadal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '04', 'subspecific' => '09',
                'denomination' => 'Donaciones corrientes internas del Poder Municipal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Transferencias corrientes del exterior',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '05', 'subspecific' => '01',
                'denomination' => 'Transferencias corrientes de instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '05', 'subspecific' => '02',
                'denomination' => 'Transferencias corrientes de gobiernos extranjeros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '05', 'subspecific' => '03',
                'denomination' => 'Transferencias corrientes de organismos internacionales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Donaciones corrientes del exterior',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '06', 'subspecific' => '01',
                'denomination' => 'Donaciones corrientes de  personas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '06', 'subspecific' => '02',
                'denomination' => 'Donaciones corrientes de instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '06', 'subspecific' => '03',
                'denomination' => 'Donaciones corrientes de gobiernos extranjeros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '01', 'specific' => '06', 'subspecific' => '04',
                'denomination' => 'Donaciones corrientes de organismos internacionales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Transferencias y donaciones de capital',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Transferencias de capital internas del sector privado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Transferencias de capital internas de personas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Transferencias de capital internas de instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Transferencias de capital internas de empresas privadas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Donaciones  de capital internas del sector privado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Donaciones de capital internas de personas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Donaciones de capital internas de instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Donaciones de capital internas de empresas privadas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Transferencias de capital internas del sector público',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Transferencias de capital internas de la República',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Transferencias de capital internas de entes descentralizados sin ' .
                                  'fines empresariales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '03', 'subspecific' => '03',
                'denomination' => 'Transferencias de capital internas de instituciones de protección social',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '03', 'subspecific' => '04',
                'denomination' => 'Transferencias de capital internas de entes descentralizados con fines ' .
                                  'empresariales petroleros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '03', 'subspecific' => '05',
                'denomination' => 'Transferencias de capital internas de entes descentralizados con fines ' .
                                  'empresariales no petroleros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '03', 'subspecific' => '06',
                'denomination' => 'Transferencias de capital internas de entes descentralizados financieros bancarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '03', 'subspecific' => '07',
                'denomination' => 'Transferencias de capital internas de entes descentralizados ' .
                                  'financieros no bancarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '03', 'subspecific' => '08',
                'denomination' => 'Transferencias de capital internas del Poder Estadal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '03', 'subspecific' => '09',
                'denomination' => 'Transferencias de capital internas del Poder Municipal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Donaciones de capital internas del sector público',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '04', 'subspecific' => '01',
                'denomination' => 'Donaciones de capital internas de la República',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '04', 'subspecific' => '02',
                'denomination' => 'Donaciones de capital internas de entes descentralizados sin fines empresariales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '04', 'subspecific' => '03',
                'denomination' => 'Donaciones de capital internas de instituciones de protección social',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '04', 'subspecific' => '04',
                'denomination' => 'Donaciones de capital internas de entes descentralizados con fines ' .
                                  'empresariales petroleros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '04', 'subspecific' => '05',
                'denomination' => 'Donaciones de capital internas de entes descentralizados con fines ' .
                                  'empresariales no petroleros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '04', 'subspecific' => '06',
                'denomination' => 'Donaciones de capital internas de entes descentralizados financieros bancarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '04', 'subspecific' => '07',
                'denomination' => 'Donaciones de capital internas de entes descentralizados financieros no bancarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '04', 'subspecific' => '08',
                'denomination' => 'Donaciones de capital internas del Poder Estadal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '04', 'subspecific' => '09',
                'denomination' => 'Donaciones de capital internas del Poder Municipal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Transferencias de capital del exterior',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '05', 'subspecific' => '01',
                'denomination' => 'Transferencias de capital de instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '05', 'subspecific' => '02',
                'denomination' => 'Transferencias de capital de gobiernos extranjeros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '05', 'subspecific' => '03',
                'denomination' => 'Transferencias de capital de organismos internacionales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Donaciones de capital del exterior',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '06', 'subspecific' => '01',
                'denomination' => 'Donaciones de capital de  personas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '06', 'subspecific' => '02',
                'denomination' => 'Donaciones de capital de instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '06', 'subspecific' => '03',
                'denomination' => 'Donaciones de capital de gobiernos extranjeros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '06', 'subspecific' => '04',
                'denomination' => 'Donaciones de capital de organismos internacionales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Situado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Situado Constitucional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '03', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Situado Estadal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '03', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Situado Municipal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '03', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Subsidio de Régimen Especial',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Situado Estadal a Municipal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Subsidio de Régimen Especial',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Subsidio de Régimen Especial',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Subsidio de Capitalidad',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Subsidio de Capitalidad',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '09', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Aporte a los Estados y Municipios por transferencia de servicios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones Económicas Especiales (LAEE)',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones Económicas Especiales (LAEE) Estadal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '07', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Fondo Intergubernamental para la Descentralización (FIDES)',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '07', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Fondo Intergubernamental para la Descentralización (FIDES)',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '08', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Fondo de Compensación Interterritorial',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '08', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Fondo de Compensación Interterritorial Estadal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '08', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Fondo de Compensación Interterritorial Municipal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'RECURSOS PROPIOS DE CAPITAL',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Venta y/o desincorporación de activos fijos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Venta y/o desincorporación de tierras y terrenos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Venta y/o desincorporación de edificios e instalaciones',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '01', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Venta y/o desincorporación de maquinarias, equipos y semovientes',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '01', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Venta y/o desincorporación de maquinarias y demás equipos de construcción, ' .
                                  'campo, industria y taller',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '01', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Venta y/o desincorporación de equipos de transporte, tracción y elevación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '01', 'specific' => '03', 'subspecific' => '03',
                'denomination' => 'Venta y/o desincorporación de equipos de comunicaciones y de señalamiento',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '01', 'specific' => '03', 'subspecific' => '04',
                'denomination' => 'Venta y/o desincorporación de equipos médico - quirúrgicos, ' .
                                  'dentales y de veterinaria',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '01', 'specific' => '03', 'subspecific' => '05',
                'denomination' => 'Venta y/o desincorporación de equipos cientí­ficos, religiosos, ' .
                                  'de enseñanza y recreación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '01', 'specific' => '03', 'subspecific' => '06',
                'denomination' => 'Venta y/o desincorporación de equipos para la seguridad pública',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '01', 'specific' => '03', 'subspecific' => '07',
                'denomination' => 'Venta y/o desincorporación de máquinas, muebles y demás equipos de ' .
                                  'oficina y alojamiento',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '01', 'specific' => '03', 'subspecific' => '08',
                'denomination' => 'Venta y/o desincorporación de semovientes',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '01', 'specific' => '03', 'subspecific' => '99',
                'denomination' => 'Venta y/o desincorporación de otros activos fijos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Venta de activos intangibles',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Venta de marcas de fábrica y patentes de invención',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Venta de derechos de autor',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Recuperación de gastos de organización',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '02', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Venta de paquetes y programas de computación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '02', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Venta de estudios y proyectos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '02', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Venta de otros activos intangibles',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de la depreciación y amortización acumuladas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de la depreciación acumulada',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Incremento de la depreciación acumulada de edificios en instalaciones',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Incremento de la depreciación acumulada de maquinarias y demás equipos ' .
                                  'de construcción, campo, industria y taller',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Incremento de la depreciación acumulada de equipos de transporte, ' .
                                  'tracción y elevación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Incremento de la depreciación acumulada de equipos de comunicaciones ' .
                                  'y de señalamiento',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '01', 'subspecific' => '05',
                'denomination' => 'Incremento de la depreciación acumulada de equipos médico - quirúrgicos, ' .
                                'dentales y de veterinaria',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '01', 'subspecific' => '06',
                'denomination' => 'Incremento de la depreciación acumulada de equipos cientí­ficos, religiosos, ' .
                                  'de enseñanza y recreación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '01', 'subspecific' => '07',
                'denomination' => 'Incremento de la depreciación acumulada de equipos para la seguridad pública',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '01', 'subspecific' => '08',
                'denomination' => 'Incremento de la depreciación acumulada de máquinas, muebles y demás ' .
                                  'equipos de oficina y alojamiento',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '01', 'subspecific' => '09',
                'denomination' => 'Incremento de la depreciación acumulada de semovientes',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '01', 'subspecific' => '99',
                'denomination' => 'Incremento  de  la  depreciación acumulada de otros activos fijos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de la amortización acumulada',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Incremento de la amortización  acumulada de marcas de fábrica y ' .
                                  'patentes de invención',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Incremento de la amortización acumulada de derechos de autor',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Incremento de la amortización acumulada de gastos de organización',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Incremento de la amortización acumulada de paquetes y programas de computación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '02', 'subspecific' => '05',
                'denomination' => 'Incremento de la amortización acumulada de estudios y proyectos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '06', 'generic' => '03', 'specific' => '02', 'subspecific' => '99',
                'denomination' => 'Incremento de la amortización acumulada de otros activos intangibles',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '07', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'VENTA DE TÍTULOS Y VALORES QUE NO OTORGAN PROPIEDAD',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '07', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Venta de tí­tulos y valores de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Venta de tí­tulos y valores privados de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '07', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Venta de tí­tulos y valores públicos de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Venta de tí­tulos y valores externos de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '07', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Venta de tí­tulos y valores de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '07', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Venta de tí­tulos y valores privados de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '07', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Venta de tí­tulos y valores públicos de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '07', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Venta de tí­tulos y valores externos de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '08', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'VENTA DE ACCIONES Y PARTICIPACIONES DE CAPITAL',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '08', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Venta de acciones y participaciones de capital del sector privado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '08', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Venta de acciones y participaciones de capital del sector privado ',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '08', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Venta de acciones y participaciones de capital del sector público',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '08', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Venta de acciones y participaciones de capital de entes descentralizados ' .
                                  'sin fines empresariales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '08', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Venta de acciones y participaciones de capital de instituciones de ' .
                                  'protección social',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '08', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Venta de acciones y participaciones de capital de entes descentralizados ' .
                                  'con fines empresariales petroleros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '08', 'generic' => '02', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Venta de acciones y participaciones de capital de entes descentralizados ' .
                                  'con fines empresariales no petroleros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '08', 'generic' => '02', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Venta de acciones y participaciones de capital de entes descentralizados ' .
                                  'financieros bancarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '08', 'generic' => '02', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Venta de acciones y participaciones de capital de entes descentralizados ' .
                                  'financieros no bancarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '08', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Venta de acciones y participaciones de capital del sector externo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '08', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Venta de acciones y participaciones de capital de organismos internacionales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '08', 'generic' => '03', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Venta de acciones y participaciones de capital de otros entes del sector externo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'RECUPERACIÓN DE PRÉSTAMOS DE CORTO PLAZO',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados al sector privado de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados al sector privado de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados al sector público de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a la República de corto plazo ',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a entes descentralizados sin fines ' .
                                  'empresariales de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a instituciones de protección ' .
                                  'social de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '02', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a entes descentralizados con ' .
                                  'fines empresariales petroleros de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '02', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a entes descentralizados con fines ' .
                                  'empresariales no petroleros de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '02', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a entes descentralizados financieros ' .
                                  'bancarios de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '02', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a entes descentralizados financieros ' .
                                  'no bancarios de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '02', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados al Poder Estadal de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '02', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados al Poder Municipal de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados al sector externo de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a instituciones sin fines de lucro ' .
                                  'de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a gobiernos extranjeros de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '09', 'generic' => '03', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a los organismos internacionales de corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'RECUPERACIÓN DE PRÉSTAMOS DE LARGO PLAZO',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados al sector privado de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados al sector privado de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados al sector público de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a la República de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a entes descentralizados sin fines ' .
                                  'empresariales de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a instituciones de protección ' .
                                  'social de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '02', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a entes descentralizados con ' .
                                  'fines empresariales petroleros de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '02', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a entes descentralizados con fines ' .
                                  'empresariales no petroleros de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '02', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a entes descentralizados financieros ' .
                                  'bancarios de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '02', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a entes descentralizados financieros ' .
                                  'no bancarios de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '02', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados al Poder Estadal de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '02', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados al Poder Municipal de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados al sector externo de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a instituciones sin fines de lucro ' .
                                  'de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a gobiernos extranjeros de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Recuperación de préstamos otorgados a organismos internacionales de largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'DISMINUCIÓN DE OTROS ACTIVOS FINANCIEROS',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de disponibilidades',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de caja',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de bancos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '01', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Disminución de bancos públicos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '01', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Disminución de bancos privados',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '01', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Disminución de bancos en el exterior',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '01', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Disminución de inversiones temporales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de cuentas por cobrar a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de cuentas comerciales por cobrar a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de rentas por recaudar a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Disminución de deudas de cuentas por rendir a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '02', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Disminución de deudas de cuentadantes por rendir de fondos en avance a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '02', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Disminución de deudas de cuentadantes por rendir de fondos en anticipos ' .
                                  'a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '02', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Disminución de otras cuentas por cobrar  a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de efectos por cobrar a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de efectos comerciales por cobrar a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '03', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Disminución de otros efectos por cobrar a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de cuentas por cobrar a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de cuentas comerciales por cobrar a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de rentas por recaudar a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '04', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Disminución de otras cuentas por cobrar a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de efectos por cobrar a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de efectos comerciales por cobrar a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '05', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Disminución de otros efectos por cobrar a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de fondos en avance, anticipo y en fideicomiso',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de fondos en avance',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '06', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de fondos en anticipo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '06', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Disminución de fondos en fideicomiso',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '06', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Disminución de anticipos a proveedores',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '06', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Disminución de anticipos a contratistas, por contratos a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '06', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Disminución de anticipos a contratistas, por contratos a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '07', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de activos diferidos a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '07', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de gastos a corto plazo pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '07', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Disminución de intereses de la deuda pública interna a corto plazo ' .
                                  'pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '07', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Disminución de intereses de la deuda pública externa a corto plazo ' .
                                  'pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '07', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Disminución de otros intereses a corto plazo pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '07', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Disminución de débitos por apertura de cartas de crédito a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '07', 'specific' => '01', 'subspecific' => '99',
                'denomination' => 'Disminución de otros gastos a corto plazo pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '07', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de depósitos en garantía a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '07', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Disminución de otros activos diferidos a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '08', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de activos diferidos a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '08', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de gastos a mediano y largo plazo pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '08', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Disminución de intereses de la deuda pública interna a largo plazo ' .
                                  'pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '08', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Disminución de intereses de la deuda pública externa a largo plazo ' .
                                  'pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '08', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Disminución de otros intereses a mediano y largo plazo pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '08', 'specific' => '01', 'subspecific' => '99',
                'denomination' => 'Disminución de otros gastos a mediano y largo plazo pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '08', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de depósitos en garantía a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '08', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Disminución de otros activos diferidos a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '09', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución del Fondo de Estabilización Macroeconómica (FEM)',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '09', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución del Fondo de Estabilización Macroeconómica (FEM) de la República',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '09', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución del Fondo de Estabilización Macroeconómica (FEM) del Poder Estadal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '09', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Disminución del Fondo de Estabilización Macroeconómica (FEM) del Poder Municipal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '10', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución del Fondo de Ahorro Intergeneracional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '10', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución del Fondo de Ahorro Intergeneracional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '11', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución del Fondo de Desarrollo Nacional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '11', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución del Fondo de Desarrollo Nacional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '12', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución del Fondo de Aporte del Sector Público',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '12', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución del Fondo de Aporte del Sector Público',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '20', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de activos en proceso judicial',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '20', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de activos financieros en gestión judicial a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '20', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de tí­tulos y otros valores de la deuda pública en litigio a ' .
                                  'largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '99', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de otros activos financieros ',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '99', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de otros activos financieros circulantes',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '11', 'generic' => '99', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de otros activos financieros no circulantes',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'INCREMENTO DE PASIVOS',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de gastos de personal por pagar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de sueldos, salarios y otras remuneraciones por pagar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de aportes patronales y retenciones laborales por pagar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de aportes patronales y retenciones laborales por pagar al ' .
                                  'Instituto Venezolano de los Seguros Sociales (IVSS)',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de aportes patronales y retenciones laborales por pagar al ' .
                                  'Instituto de Previsión Social del Ministerio de Educación (Ipasme)',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Incremento de aportes patronales y retenciones laborales por pagar al ' .
                                  'Fondo de Jubilaciones',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '02', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Incremento de aportes patronales y retenciones laborales por pagar al ' .
                                  'Fondo de Seguro de Paro Forzoso',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '02', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Incremento de aportes patronales y retenciones laborales por pagar al ' .
                                  'Fondo de Ahorro Habitacional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '02', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Incremento de aportes patronales y retenciones laborales por pagar por ' .
                                  'seguro de vida, accidentes personales, hospitalización, cirugía y ' .
                                  'maternidad (HCM) y gastos funerarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '02', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Incremento de aportes patronales y retenciones laborales por pagar a ' .
                                  'cajas de ahorro',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '02', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Incremento de aportes patronales y retenciones laborales por pagar a ' .
                                  'los organismos de seguridad social',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '02', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Incremento de aportes patronales y retenciones laborales por pagar al ' .
                                  'Instituto de Cooperación Educativa (INCE)',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '02', 'specific' => '10', 'subspecific' => '00',
                'denomination' => 'Incremento de aportes patronales y retenciones laborales por pagar por ' .
                                  'pensión alimenticia',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '02', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Incremento de otros aportes patronales y otras retenciones laborales por pagar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '02', 'specific' => '99', 'subspecific' => '01',
                'denomination' => 'Incremento de otros aportes patronales por pagar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '02', 'specific' => '99', 'subspecific' => '02',
                'denomination' => 'Incremento de otras retenciones laborales por pagar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de cuentas y efectos por pagar a proveedores',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de cuentas por pagar a proveedores a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de efectos por pagar a proveedores a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '03', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Incremento de cuentas por pagar a proveedores a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '03', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Incremento de efectos por pagar a proveedores a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de cuentas y efectos por pagar a contratistas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de cuentas por pagar a contratistas a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de efectos por pagar a contratistas a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '04', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Incremento de cuentas por pagar a contratistas  a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '04', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Incremento de efectos por pagar a contratistas  a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de intereses por pagar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de intereses internos por pagar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '05', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de intereses externos por pagar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de otras cuentas y efectos por pagar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de otras cuentas por pagar a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '06', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de otras obligaciones de ejercicios anteriores por pagar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '06', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Incremento de otros efectos por pagar a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '07', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de pasivos diferidos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '07', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de pasivos diferidos a  corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '07', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Incremento de rentas diferidas por recaudar a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '07', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de pasivos diferidos a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '07', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Incremento de colocación de certificados de reintegro tributario',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '07', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Incremento de colocación de bonos de exportación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '07', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Incremento de colocación de bonos en dación de pagos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '08', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de provisiones y reservas técnicas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '08', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de provisiones ',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '08', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Incremento de provisiones para cuentas incobrables',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '08', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Incremento de provisiones para despidos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '08', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Incremento de provisiones para pérdidas de inventarios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '08', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Incremento de provisiones para beneficios sociales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '08', 'specific' => '01', 'subspecific' => '99',
                'denomination' => 'Incremento de otras provisiones ',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '08', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de reservas técnicas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '09', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de fondos de terceros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '09', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de depósitos recibidos en garantí­a',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '09', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Incremento de otros fondos de terceros',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '10', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de depósitos en instituciones financieras',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '10', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de depósitos a la vista',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '10', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Incremento de depósitos a la vista de organismos del sector público',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '10', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Incremento de depósitos a la vista de personas naturales y jurí­dicas ' .
                                  'del sector privado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '10', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de depósitos a plazo fijo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '10', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Incremento de depósitos a plazo fijo de organismos del sector público',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '10', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Incremento de depósitos a plazo fijo de personas naturales y jurí­dicas ' .
                                  'del sector privado',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '11', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Reestructuración y/o refinanciamiento de la deuda pública',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '11', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento por reestructuración y/o refinanciamiento de la deuda pública ' .
                                  'interna de largo plazo en corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '11', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento por reestructuración y/o refinanciamiento de la deuda pública ' .
                                  'interna de corto plazo en largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '11', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Incremento por reestructuración y/o refinanciamiento de la deuda pública ' .
                                  'externa de largo plazo en corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '11', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Incremento por reestructuración y/o refinanciamiento de la deuda pública ' .
                                  'externa de corto plazo en largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '11', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Incremento de la deuda pública por distribuir',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '11', 'specific' => '05', 'subspecific' => '01',
                'denomination' => 'Incremento de la deuda pública interna por distribuir',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '11', 'specific' => '05', 'subspecific' => '02',
                'denomination' => 'Incremento de la deuda pública externa por distribuir',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '99', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de otros pasivos ',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '99', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de otros pasivos a corto plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '12', 'generic' => '99', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de otros pasivos  a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '13', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'INCREMENTO DEL PATRIMONIO',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '13', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento del capital ',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '13', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento del capital fiscal e institucional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '13', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de aportes por capitalizar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '13', 'generic' => '01', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Incremento de dividendos a distribuir',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '13', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de reservas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '13', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de reservas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '13', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ajustes por inflación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '13', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Ajustes por inflación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '13', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de resultados',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '13', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de resultados acumulados',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '13', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de resultados del ejercicio',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '00', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'EGRESOS',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'GASTOS DE PERSONAL',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Sueldos, salarios y otras retribuciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Sueldos básicos personal fijo a tiempo completo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Sueldos básicos personal fijo a tiempo parcial',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Suplencias a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Sueldo al personal en trámite de nombramiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Remuneraciones al personal en perí­odo de disponibilidad',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '10', 'subspecific' => '00',
                'denomination' => 'Salarios a obreros en puestos permanentes a tiempo completo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '11', 'subspecific' => '00',
                'denomination' => 'Salarios a obreros en puestos permanentes a tiempo parcial',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '12', 'subspecific' => '00',
                'denomination' => 'Salarios a obreros en puestos no permanentes',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '13', 'subspecific' => '00',
                'denomination' => 'Suplencias a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '18', 'subspecific' => '00',
                'denomination' => 'Remuneraciones al personal contratado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '19', 'subspecific' => '00',
                'denomination' => 'Retribuciones por becas - salarios, bolsas de trabajo, pasantí­as y similares',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '20', 'subspecific' => '00',
                'denomination' => 'Sueldo del personal militar profesional',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '21', 'subspecific' => '00',
                'denomination' => 'Sueldo o ración del personal militar no profesional',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '22', 'subspecific' => '00',
                'denomination' => 'Sueldo del personal militar de reserva',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '27', 'subspecific' => '00',
                'denomination' => 'Remuneraciones a parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '28', 'subspecific' => '00',
                'denomination' => 'Suplencias a parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '29', 'subspecific' => '00',
                'denomination' => 'Dietas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otras retribuciones ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Compensaciones previstas en las escalas de sueldos y salarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Compensaciones previstas en las escalas de sueldos al personal empleado ' .
                                  'fijo a tiempo completo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Compensaciones previstas en las escalas de sueldos al personal empleado ' .
                                  'fijo a tiempo parcial',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Compensaciones previstas en las escalas de salarios al personal obrero ' .
                                  'fijo  a tiempo completo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '02', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Compensaciones previstas en las escalas de salarios al personal obrero ' .
                                  'fijo a tiempo parcial',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '02', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Compensaciones previstas en las escalas de sueldos al personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Primas a empleados, obreros, personal militar y parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Primas por mérito a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Primas de transporte a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Primas por hogar a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Primas por hijos a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Primas por alquileres a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Primas por residencia a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Primas por categorí­a de escuelas a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Primas de profesionalización a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Primas por antigüedad a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '10', 'subspecific' => '00',
                'denomination' => 'Primas por jerarquí­a o responsabilidad en el cargo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '11', 'subspecific' => '00',
                'denomination' => 'Primas al personal en servicio en el exterior',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '16', 'subspecific' => '00',
                'denomination' => 'Primas por mérito a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '17', 'subspecific' => '00',
                'denomination' => 'Primas de transporte a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '18', 'subspecific' => '00',
                'denomination' => 'Primas por hogar a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '19', 'subspecific' => '00',
                'denomination' => 'Primas por hijos de obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '20', 'subspecific' => '00',
                'denomination' => 'Primas por residencia a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '21', 'subspecific' => '00',
                'denomination' => 'Primas por antigüedad a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '26', 'subspecific' => '00',
                'denomination' => 'Primas por hijos al personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '27', 'subspecific' => '00',
                'denomination' => 'Primas de profesionalización al personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '28', 'subspecific' => '00',
                'denomination' => 'Primas por antigüedad al personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '29', 'subspecific' => '00',
                'denomination' => 'Primas por potencial de ascenso al personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '30', 'subspecific' => '00',
                'denomination' => 'Primas por frontera y sitios inhóspitos al personal militar y de seguridad',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '31', 'subspecific' => '00',
                'denomination' => 'Primas por riesgo al personal militar y de seguridad',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '36', 'subspecific' => '00',
                'denomination' => 'Primas a parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '97', 'subspecific' => '00',
                'denomination' => 'Otras primas a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '98', 'subspecific' => '00',
                'denomination' => 'Otras primas a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '03', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otras primas al personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Complementos de sueldos y salarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Complemento a empleados por horas extraordinarias o por sobre tiempo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Complemento a empleados por trabajo nocturno ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Complemento a empleados por gastos de alimentación ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Complemento a empleados por gastos de transporte ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Complemento a empleados por gastos de representación ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Complemento a empleados por comisión de servicios ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Bonificación a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Bono compensatorio de alimentación a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Bono compensatorio de transporte a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '14', 'subspecific' => '00',
                'denomination' => 'Complemento a obreros por horas extraordinarias o por sobre tiempo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '15', 'subspecific' => '00',
                'denomination' => 'Complemento a obreros por trabajo o jornada nocturna ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '16', 'subspecific' => '00',
                'denomination' => 'Complemento a obreros por gastos de alimentación ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '17', 'subspecific' => '00',
                'denomination' => 'Complemento a obreros por gastos de transporte ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '18', 'subspecific' => '00',
                'denomination' => 'Bono compensatorio de alimentación a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '19', 'subspecific' => '00',
                'denomination' => 'Bono compensatorio de transporte a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '24', 'subspecific' => '00',
                'denomination' => 'Complemento al personal contratado por horas extraordinarias o por sobre tiempo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '25', 'subspecific' => '00',
                'denomination' => 'Complemento al personal contratado por gastos de alimentación ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '26', 'subspecific' => '00',
                'denomination' => 'Bono compensatorio de alimentación al personal contratado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '27', 'subspecific' => '00',
                'denomination' => 'Bono compensatorio de transporte al personal contratado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '32', 'subspecific' => '00',
                'denomination' => 'Complemento al personal militar por gastos de alimentación ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '33', 'subspecific' => '00',
                'denomination' => 'Complemento al personal militar por gastos de transporte ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '34', 'subspecific' => '00',
                'denomination' => 'Complemento al personal militar en el exterior ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '35', 'subspecific' => '00',
                'denomination' => 'Bono compensatorio de alimentación al personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '40', 'subspecific' => '00',
                'denomination' => 'Complemento a parlamentarios por gastos de alimentación ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '41', 'subspecific' => '00',
                'denomination' => 'Complemento a parlamentarios por gastos de transporte ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '42', 'subspecific' => '00',
                'denomination' => 'Complemento a parlamentarios por gastos de representación ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '96', 'subspecific' => '00',
                'denomination' => 'Otros complementos a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '97', 'subspecific' => '00',
                'denomination' => 'Otros complementos a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '98', 'subspecific' => '00',
                'denomination' => 'Otros complementos al personal contratado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros complementos al personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Aguinaldos, utilidades o bonificación legal, y bono vacacional a ' .
                                  'empleados, obreros, contratados, personal militar y parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Aguinaldos a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Utilidades legales y convencionales a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Bono vacacional a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Aguinaldos a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Utilidades legales y convencionales a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Bono vacacional a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Aguinaldos al personal contratado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Bono vacacional al personal contratado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Aguinaldos al personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '10', 'subspecific' => '00',
                'denomination' => 'Bono vacacional al personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '11', 'subspecific' => '00',
                'denomination' => 'Aguinaldos a parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '12', 'subspecific' => '00',
                'denomination' => 'Bono vacacional a parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Aportes patronales por empleados, obreros, personal militar y parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al Instituto Venezolano de los Seguros Sociales (IVSS) ' .
                                  'por empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al Instituto de Previsión y Asistencia Social para el ' .
                                  'personal del Ministerio de Educación (IPASME) por empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al Fondo de Jubilaciones por empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al Fondo de Seguro de Paro Forzoso por empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al Fondo de Ahorro Habitacional por empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '10', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al Instituto Venezolano de los Seguros Sociales (IVSS) ' .
                                  'por obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '11', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al Fondo de Jubilaciones por obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '12', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al Fondo de Seguro de Paro Forzoso por obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '13', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al Fondo de Ahorro Habitacional por obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '18', 'subspecific' => '00',
                'denomination' => 'Aporte patronal a los organismos de seguridad social por los trabajadores ' .
                                  'locales empleados en las representaciones de Venezuela en el exterior',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '19', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al Fondo de Ahorro Habitacional por personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '24', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al Fondo de Ahorro Habitacional a parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '96', 'subspecific' => '00',
                'denomination' => 'Otros aportes legales por empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '97', 'subspecific' => '00',
                'denomination' => 'Otros aportes legales por obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '98', 'subspecific' => '00',
                'denomination' => 'Otros aportes legales por personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros aportes legales por parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asistencia socio-económica a empleados, obreros, contratados, personal ' .
                                  'militar y parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Capacitación y adiestramiento a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Becas a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Ayudas por matrimonio a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Ayudas por nacimiento de hijos a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Ayudas por defunción a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Ayudas para medicinas, gastos médicos,  odontológicos y de hospitalización ' .
                                  'a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Aporte patronal a cajas de ahorro por empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al seguro de vida, accidentes personales, hospitalización, ' .
                                  'cirugí­a, maternidad (HCM) y gastos funerarios por empleados',
                'active' => false
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Ayudas a empleados para adquisición de uniformes y útiles escolares de sus hijos ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '10', 'subspecific' => '00',
                'denomination' => 'Dotación de uniformes a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '11', 'subspecific' => '00',
                'denomination' => 'Aporte patronal para gastos de guarderí­as y preescolar para hijos de empleados ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '12', 'subspecific' => '00',
                'denomination' => 'Aportes para la adquisición de juguetes para los hijos del personal empleado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '17', 'subspecific' => '00',
                'denomination' => 'Capacitación y adiestramiento a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '18', 'subspecific' => '00',
                'denomination' => 'Becas a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '19', 'subspecific' => '00',
                'denomination' => 'Ayudas por matrimonio de obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '20', 'subspecific' => '00',
                'denomination' => 'Ayudas por nacimiento de hijos de obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '21', 'subspecific' => '00',
                'denomination' => 'Ayudas por defunción a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '22', 'subspecific' => '00',
                'denomination' => 'Ayudas para medicinas, gastos médicos,  odontológicos y de hospitalización ' .
                                  'a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '23', 'subspecific' => '00',
                'denomination' => 'Aporte patronal a cajas de ahorro por obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '24', 'subspecific' => '00',
                'denomination' => 'Aporte patronal a los servicios de salud, accidentes personales y gastos ' .
                                  'funerarios por obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '25', 'subspecific' => '00',
                'denomination' => 'Ayudas a obreros para adquisición de uniformes y útiles escolares de sus hijos ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '26', 'subspecific' => '00',
                'denomination' => 'Dotación de uniformes a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '27', 'subspecific' => '00',
                'denomination' => 'Aporte patronal para gastos de guarderí­as y preescolar para hijos de obreros ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '28', 'subspecific' => '00',
                'denomination' => 'Aportes para la adquisición de juguetes para los hijos del personal obrero',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '33', 'subspecific' => '00',
                'denomination' => 'Asistencia socio-económica al personal contratado ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '34', 'subspecific' => '00',
                'denomination' => 'Capacitación y adiestramiento al personal militar ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '35', 'subspecific' => '00',
                'denomination' => 'Becas al personal militar ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '36', 'subspecific' => '00',
                'denomination' => 'Ayudas por matrimonio al personal militar ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '37', 'subspecific' => '00',
                'denomination' => 'Ayudas por nacimiento de hijos al personal militar ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '38', 'subspecific' => '00',
                'denomination' => 'Ayudas por defunción al personal militar ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '39', 'subspecific' => '00',
                'denomination' => 'Ayudas para medicinas, gastos médicos, odontológicos y de hospitalización ' .
                                  'al personal militar ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '40', 'subspecific' => '00',
                'denomination' => 'Aporte patronal a caja de ahorro por personal militar ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '41', 'subspecific' => '00',
                'denomination' => 'Aporte patronal a los servicios de salud, accidentes personales y gastos ' .
                                  'funerarios personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '42', 'subspecific' => '00',
                'denomination' => 'Ayudas al personal militar para adquisición de uniformes y útiles escolares ' .
                                  'de sus hijos ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '43', 'subspecific' => '00',
                'denomination' => 'Aportes para la adquisición de juguetes para los hijos del personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '48', 'subspecific' => '00',
                'denomination' => 'Ayudas para medicinas, gastos médicos, odontológicos y de hospitalización ' .
                                  'de parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '49', 'subspecific' => '00',
                'denomination' => 'Aporte patronal a cajas de ahorro por parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '50', 'subspecific' => '00',
                'denomination' => 'Aporte patronal a los servicios de salud, accidentes personales y gastos ' .
                                  'funerarios por parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '96', 'subspecific' => '00',
                'denomination' => 'Otras subvenciones a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '97', 'subspecific' => '00',
                'denomination' => 'Otras subvenciones a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '98', 'subspecific' => '00',
                'denomination' => 'Otras subvenciones al personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otras subvenciones a parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '08', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Prestaciones sociales e indemnizaciones a empleados, obreros, contratados, ' .
                                  'personal militar y parlamentarios ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '08', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Prestaciones sociales e indemnizaciones a empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '08', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Prestaciones sociales e indemnizaciones a obreros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '08', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Prestaciones sociales e indemnizaciones al personal contratado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '08', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Prestaciones sociales e indemnizaciones al personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '08', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Prestaciones sociales e indemnizaciones a parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '09', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Capacitación y adiestramiento realizado por personal del organismo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '09', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Capacitación y adiestramiento realizado por personal del organismo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '96', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Otros gastos del personal empleado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '96', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Otros gastos del personal empleado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '97', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Otros gastos del personal obrero',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '97', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Otros gastos del personal obrero',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '98', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Otros gastos del personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '98', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Otros gastos del personal militar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '99', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Otros gastos de los parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '99', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Otros gastos de los parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'MATERIALES, SUMINISTROS Y MERCANCÍAS',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Productos alimenticios y agropecuarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Alimentos y bebidas para personas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Alimentos para animales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '01', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Productos agrí­colas y pecuarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '01', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Productos de la caza y pesca',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '01', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros productos alimenticios y agropecuarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Productos de minas, canteras y yacimientos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Carbón mineral',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Petróleo crudo y gas natural',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Mineral de hierro',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '02', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Mineral no ferroso',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '02', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Piedra, arcilla, arena y tierra',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '02', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Mineral para la fabricación de productos quí­micos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '02', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Sal para uso industrial',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '02', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros productos de minas, canteras y yacimientos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Textiles y vestuarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Textiles',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Prendas de vestir',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '03', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Calzados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '03', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros productos textiles y vestuarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Productos de cuero y caucho',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Cueros y pieles',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Productos de cuero y sucedáneos del cuero',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '04', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Cauchos y tripas para vehí­culos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '04', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros productos de cuero y caucho',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Productos de papel, cartón e impresos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Pulpa de madera, papel y cartón',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '05', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Envases y cajas de papel y cartón',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '05', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Productos de papel y cartón para oficina',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '05', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Libros, revistas y periódicos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '05', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Material de enseñanza',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '05', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Productos de papel y cartón para computación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '05', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Productos de papel y cartón para la imprenta y reproducción',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '05', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros productos de pulpa, papel y cartón',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Productos quí­micos y derivados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Sustancias quí­micas y de uso industrial',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '06', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Abonos, plaguicidas y otros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '06', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Tintas, pinturas y colorantes',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '06', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Productos farmacéuticos y medicamentos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '06', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Productos de tocador',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '06', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Combustibles y lubricantes',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '06', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Productos diversos derivados del petróleo y del carbón',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '06', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Productos plásticos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '06', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Mezclas explosivas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '06', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros productos de la industria quí­mica y conexos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '07', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Productos minerales no metálicos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '07', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Productos de barro, loza y porcelana',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '07', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Vidrios y productos de vidrio',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '07', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Productos de arcilla para construcción',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '07', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Cemento, cal  y yeso',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '07', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros productos minerales no metálicos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '08', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Productos metálicos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '08', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Productos primarios de hierro y acero',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '08', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Productos de metales no ferrosos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '08', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Herramientas menores, cuchillerí­a y artí­culos generales de ferretería',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '08', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Productos metálicos estructurales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '08', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Materiales de orden público, seguridad y defensa',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '08', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Material de seguridad pública',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '08', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Material de señalamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '08', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Material de educación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '08', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Repuestos y accesorios para equipos de transporte',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '08', 'specific' => '10', 'subspecific' => '00',
                'denomination' => 'Repuestos y accesorios para otros equipos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '08', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros productos metálicos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '09', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Productos de madera',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '09', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Productos primarios de madera',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '09', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Muebles y accesorios de madera para edificaciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '09', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros productos de madera',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Productos varios y útiles diversos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Artí­culos de deporte, recreación y juguetes',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Materiales y útiles de limpieza y aseo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Utensilios de cocina y comedor',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Útiles menores médico - quirúrgicos de laboratorio, dentales y de veterinaria',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Útiles de escritorio, oficina y materiales de instrucción',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Condecoraciones, ofrendas y similares',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Productos de seguridad en el trabajo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Materiales para equipos de computación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Especies timbradas y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '10', 'subspecific' => '00',
                'denomination' => 'Útiles religiosos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '11', 'subspecific' => '00',
                'denomination' => 'Materiales eléctricos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '12', 'subspecific' => '00',
                'denomination' => 'Materiales para instalaciones sanitarias',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '13', 'subspecific' => '00',
                'denomination' => 'Materiales fotográficos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '10', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros productos y útiles diversos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '11', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Bienes para la venta',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '11', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Productos y artí­culos para la venta',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '11', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Maquinarias y equipos para la venta',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '11', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros bienes para la venta',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '99', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Otros materiales y suministros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '02', 'generic' => '99', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Otros materiales y suministros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'SERVICIOS NO PERSONALES',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Alquileres de inmuebles',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Alquileres de edificios y locales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Alquileres de instalaciones culturales y recreativas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '01', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Alquileres de tierras y terrenos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Alquileres de maquinaria y equipos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Alquileres de maquinaria y demás equipos de construcción, campo, industria y taller',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Alquileres de equipos de transporte, tracción y elevación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Alquileres de equipos de comunicaciones y de señalamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '02', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Alquileres de equipos médico - quirúrgicos, dentales y de veterinaria',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '02', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Alquileres de equipos cientí­ficos, religiosos, de enseñanza y recreación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '02', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Alquileres de máquinas, muebles y demás equipos de oficina y alojamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '02', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Alquileres de otras maquinaria y equipos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Derechos sobre bienes intangibles',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Marcas de fábrica y patentes de invención',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Derechos de autor',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '03', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Paquetes y programas de computación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '03', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Concesión de bienes y servicios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicios básicos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Electricidad',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Gas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '04', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Agua',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '04', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Teléfonos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '04', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Servicio de comunicaciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '04', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Servicio de aseo urbano y domiciliario',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '04', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Servicio de condominio',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicio de administración, vigilancia y mantenimiento de los servicios básicos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Servicio de administración, vigilancia y mantenimiento del servicio de electricidad',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '05', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Servicio de administración, vigilancia y mantenimiento del servicio de gas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '05', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Servicio de administración, vigilancia y mantenimiento del servicio de agua',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '05', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Servicio de administración, vigilancia y mantenimiento del servicio de teléfonos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '05', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Servicio de administración, vigilancia y mantenimiento del servicio de ' .
                                  'comunicaciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '05', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Servicio de administración, vigilancia y mantenimiento del servicio de ' .
                                  'aseo urbano y domiciliario',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicios de transporte y almacenaje',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Fletes y embalajes',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '06', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Almacenaje',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '06', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Estacionamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '06', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Peaje',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '06', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Servicios de protección en traslado de fondos y de mensajerí­a',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '07', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicios de información, impresión y relaciones públicas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '07', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Publicidad y propaganda',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '07', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Imprenta y reproducción',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '07', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Relaciones sociales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '07', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Avisos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '08', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Primas y otros gastos de seguros y comisiones bancarias',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '08', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Primas y gastos de seguros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '08', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Comisiones y gastos bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '08', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Comisiones y gastos de adquisición de seguros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '09', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Viáticos y pasajes',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '09', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Viáticos y pasajes dentro del paí­s',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '09', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Viáticos y pasajes fuera del paí­s',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '09', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Asignación por kilómetros recorridos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '10', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicios profesionales y técnicos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '10', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Servicios jurí­dicos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '10', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Servicios de contabilidad y auditorí­a',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '10', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Servicios de procesamiento de datos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '10', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Servicios de ingenierí­a y arquitectónicos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '10', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Servicios médicos, odontológicos y otros servicios de sanidad',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '10', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Servicios de veterinaria',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '10', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Servicios de capacitación y adiestramiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '10', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Servicios presupuestarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '10', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Servicios de lavanderí­a y tintorería',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '10', 'specific' => '10', 'subspecific' => '00',
                'denomination' => 'Servicios de vigilancia',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '10', 'specific' => '11', 'subspecific' => '00',
                'denomination' => 'Servicios para la elaboración y suministro de comida ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '10', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros servicios profesionales y técnicos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '11', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Conservación y reparaciones menores de maquinaria y equipos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '11', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Conservación y reparaciones menores de maquinaria y demás equipos de ' .
                                  'construcción, campo, industria y taller',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '11', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Conservación y reparaciones menores de equipos de transporte, tracción y elevación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '11', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Conservación y reparaciones menores de equipos de comunicaciones y de señalamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '11', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Conservación y reparaciones menores de equipos médico-quirúrgicos, ' .
                                  'dentales y de veterinaria',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '11', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Conservación y reparaciones menores de equipos cientí­ficos, religiosos, ' .
                                  'de enseñanza y recreación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '11', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Conservación y reparaciones menores de equipos para la seguridad pública',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '11', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Conservación y reparaciones menores de máquinas, muebles y demás equipos ' .
                                  'de oficina y alojamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '11', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Conservación y reparaciones menores de otras maquinaria y equipos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '12', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Conservación y reparaciones menores de obras',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '12', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Conservación y reparaciones menores de obras en bienes del dominio privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '12', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Conservación y reparaciones menores de obras en bienes del dominio público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '13', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicios de construcciones temporales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '13', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Servicios de construcciones temporales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '14', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicios de  construcción de edificios para la venta',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '14', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Servicios de construcción de edificios para la venta',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '15', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicios fiscales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '15', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Derechos de importación y servicios aduaneros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '15', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Tasas y otros derechos obligatorios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '15', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Asignación a  agentes de especies fiscales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '15', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros servicios fiscales ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '16', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicios de diversión, esparcimiento y culturales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '16', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Servicios de diversión, esparcimiento y culturales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '17', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicios de gestión administrativa prestados por organismos de asistencia técnica',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '17', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Servicios de gestión administrativa prestados por organismos de asistencia técnica',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '18', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Impuestos indirectos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '18', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Impuesto al valor agregado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '18', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros impuestos indirectos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '99', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Otros servicios no personales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '99', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Otros servicios no personales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'ACTIVOS  REALES',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Repuestos  y  reparaciones  mayores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Repuestos mayores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Repuestos mayores para maquinaria y demás equipos de construcción, campo, ' .
                                  'industria y taller',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Repuestos mayores para equipos de transporte, tracción y elevación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Repuestos mayores para equipos de comunicaciones y de señalamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Repuestos mayores para equipos médico-quirúrgicos, dentales y de veterinaria',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '01', 'subspecific' => '05',
                'denomination' => 'Repuestos mayores para equipos cientí­ficos, religiosos, de enseñanza y recreación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '01', 'subspecific' => '06',
                'denomination' => 'Repuestos mayores para equipos de seguridad pública',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '01', 'subspecific' => '07',
                'denomination' => 'Repuestos mayores para máquinas, muebles y demás equipos de oficina y alojamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '01', 'subspecific' => '99',
                'denomination' => 'Repuestos mayores para otras maquinaria y equipos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Reparaciones mayores de maquinaria y equipos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Reparaciones mayores de maquinaria y demás equipos de construcción, campo, ' .
                                  'industria y taller',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Reparaciones mayores de equipos de transporte, tracción y elevación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Reparaciones mayores de equipos de comunicaciones y de señalamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Reparaciones mayores de equipos médico - quirúrgicos, dentales y de veterinaria',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '02', 'subspecific' => '05',
                'denomination' => 'Reparaciones mayores de equipos cientí­ficos, religiosos, de enseñanza y recreación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '02', 'subspecific' => '06',
                'denomination' => 'Reparaciones mayores de equipos de seguridad pública',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '02', 'subspecific' => '07',
                'denomination' => 'Reparaciones mayores de máquinas, muebles y demás equipos de oficina y alojamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '01', 'specific' => '02', 'subspecific' => '99',
                'denomination' => 'Reparaciones mayores de otras maquinaria y equipos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Conservación, ampliaciones y mejoras mayores de obras',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Conservación, ampliaciones y mejoras mayores de obras en bienes del dominio privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Conservación, ampliaciones y mejoras mayores de obras en bienes del dominio público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Maquinaria y demás equipos de construcción, campo, industria y taller',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Maquinaria y demás equipos de construcción y mantenimiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Maquinaria y equipos para mantenimiento de automotores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '03', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Maquinaria y equipos agrí­colas y pecuarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '03', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Maquinaria y equipos de artes gráficas y reproducción',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '03', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Maquinaria y equipos industriales y de taller',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '03', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Maquinaria y equipos de energí­a',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '03', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Maquinaria y equipos de riego y acueductos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '03', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Equipos de almacén',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '03', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otra maquinaria y demás equipos de construcción, campo, industria y taller ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Equipos de transporte, tracción y elevación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Vehí­culos automotores terrestres',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Equipos ferroviarios y de cables aéreos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '04', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Equipos marí­timos de transporte',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '04', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Equipos aéreos de transporte',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '04', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Vehí­culos de tracción no motorizados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '04', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Equipos auxiliares de transporte',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '04', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros equipos de transporte, tracción y elevación ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Equipos de comunicaciones y de señalamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Equipos de telecomunicaciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '05', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Equipos de señalamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '05', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Equipos de control de tráfico aéreo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '05', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Equipos de correo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '05', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros equipos de comunicaciones y de señalamiento  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Equipos médico - quirúrgicos, dentales y de veterinaria',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Equipos médico - quirúrgicos, dentales y de veterinaria',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '06', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros equipos médico - quirúrgicos, dentales y de veterinaria',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '07', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Equipos cientí­ficos, religiosos, de enseñanza y recreación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '07', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Equipos cientí­ficos y de laboratorio',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '07', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Equipos de enseñanza, deporte y recreación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '07', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Obras de arte',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '07', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Libros, revistas y otros instrumentos de enseñanzas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '07', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Equipos religiosos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '07', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Instrumentos musicales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '07', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros equipos cientí­ficos, religiosos, de enseñanza y recreación ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '08', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Equipos y armamentos de orden público, seguridad y defensa',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '08', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Equipos y armamentos de orden público, seguridad y defensa nacional',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '08', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros equipos y armamentos de orden público, seguridad y defensa',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '09', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Máquinas, muebles y demás equipos de oficina y alojamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '09', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Mobiliario y equipos de oficina',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '09', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Equipos de computación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '09', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Mobiliario y equipos de alojamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '09', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otras máquinas, muebles y demás equipos de oficina y alojamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '10', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Semovientes',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '10', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Semovientes',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '11', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Inmuebles, maquinaria y equipos usados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '11', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Adquisición de tierras y terrenos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '11', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Adquisición de edificios e instalaciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '11', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Expropiación de tierras y terrenos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '11', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Expropiación de edificios e instalaciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '11', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Adquisición de maquinaria y equipos usados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '11', 'specific' => '05', 'subspecific' => '01',
                'denomination' => 'Maquinaria y demás equipos de construcción, campo, industria y taller',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '11', 'specific' => '05', 'subspecific' => '02',
                'denomination' => 'Equipos de transporte, tracción y elevación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '11', 'specific' => '05', 'subspecific' => '03',
                'denomination' => 'Equipos de comunicaciones y de señalamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '11', 'specific' => '05', 'subspecific' => '04',
                'denomination' => 'Equipos médico - quirúrgicos, dentales y  de veterinaria',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '11', 'specific' => '05', 'subspecific' => '05',
                'denomination' => 'Equipos cientí­ficos, religiosos, de enseñanza y recreación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '11', 'specific' => '05', 'subspecific' => '06',
                'denomination' => 'Equipos para seguridad pública',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '11', 'specific' => '05', 'subspecific' => '07',
                'denomination' => 'Máquinas, muebles y demás equipos de oficina y alojamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '11', 'specific' => '05', 'subspecific' => '99',
                'denomination' => 'Otras maquinaria y equipos usados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '12', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Activos intangibles',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '12', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Marcas de fábrica y patentes de invención',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '12', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Derechos de autor',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '12', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Gastos de organización',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '12', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Paquetes y programas de computación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '12', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Estudios y proyectos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '12', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros activos intangibles ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '13', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Estudios y proyectos para inversión en activos fijos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '13', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Estudios y proyectos aplicables a bienes del dominio privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '13', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Estudios y proyectos aplicables a bienes del dominio público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '14', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Contratación de inspección de obras',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '14', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Contratación de inspección de obras de bienes del dominio privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '14', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Contratación de inspección de obras de bienes del dominio público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '15', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Construcciones del dominio privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '15', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Construcciones de edificios médico-asistenciales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '15', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Construcciones de edificios militares y de seguridad',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '15', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Construcciones de edificios educativos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '15', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Construcciones de edificios culturales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '15', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Construcciones de edificios para oficina',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '15', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Construcciones de edificios industriales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '16', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Construcciones del dominio público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '16', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Construcción de vialidad',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '16', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Construcción de plazas, parques y similares',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '16', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Construcciones de instalaciones hidráulicas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '16', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Construcciones de puertos y aeropuertos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '99', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Otros activos reales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '99', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Otros activos reales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'ACTIVOS  FINANCIEROS',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Aportes en acciones y participaciones de capital',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Aportes en acciones y participaciones de capital al sector privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Aportes en acciones y participaciones de capital al sector público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '01', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Aportes en acciones y participaciones de capital a entes descentralizados ' .
                                  'sin fines empresariales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '01', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Aportes en acciones y participaciones de capital a instituciones de ' .
                                  'protección social',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '01', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Aportes en acciones y participaciones de capital a entes descentralizados ' .
                                  'con fines empresariales petroleros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '01', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Aportes en acciones y participaciones de capital a entes descentralizados ' .
                                  'con fines empresariales ' .
                                  'no petroleros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '01', 'specific' => '02', 'subspecific' => '05',
                'denomination' => 'Aportes en acciones y participaciones de capital a entes descentralizados ' .
                                  'financieros bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '01', 'specific' => '02', 'subspecific' => '06',
                'denomination' => 'Aportes en acciones y participaciones de capital a entes descentralizados ' .
                                  'financieros no bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '01', 'specific' => '02', 'subspecific' => '07',
                'denomination' => 'Aportes en acciones y participaciones de capital  a organismos del sector ' .
                                  'público para el pago de su deuda',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '01', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Aportes en acciones y participaciones de capital al sector externo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '01', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Aportes en acciones y participaciones de capital a organismos internacionales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '01', 'specific' => '03', 'subspecific' => '99',
                'denomination' => 'Otros aportes en acciones y participaciones de capital  al sector  externo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Adquisición de tí­tulos y valores que no otorgan propiedad',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Adquisición de tí­tulos y valores a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '02', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Adquisición de tí­tulos y valores privados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '02', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Adquisición de tí­tulos y valores públicos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '02', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Adquisición de tí­tulos y valores externos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Adquisición de tí­tulos y valores a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '02', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Adquisición de tí­tulos y valores privados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '02', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Adquisición de títulos y valores públicos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '02', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Adquisición de títulos y valores externos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Concesión de préstamos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Concesión de préstamos al sector privado a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Concesión de préstamos al sector público a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Concesión de préstamos a la República',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Concesión de préstamos a entes descentralizados sin fines empresariales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Concesión de préstamos a instituciones de protección social',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Concesión de préstamos a entes descentralizados con fines empresariales petroleros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '02', 'subspecific' => '05',
                'denomination' => 'Concesión de préstamos a entes descentralizados con fines empresariales ' .
                                  'no petroleros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '02', 'subspecific' => '06',
                'denomination' => 'Concesión de préstamos a entes descentralizados financieros bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '02', 'subspecific' => '07',
                'denomination' => 'Concesión de préstamos a entes descentralizados financieras no bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '02', 'subspecific' => '08',
                'denomination' => 'Concesión de préstamos al Poder Estadal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '02', 'subspecific' => '09',
                'denomination' => 'Concesión de préstamos al Poder Municipal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Concesión de préstamos al sector externo a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Concesión de préstamos a instituciones sin fines de lucro ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Concesión de préstamos a gobiernos extranjeros ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '03', 'specific' => '03', 'subspecific' => '03',
                'denomination' => 'Concesión de préstamos a organismos internacionales ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Concesión de préstamos a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Concesión de préstamos al sector privado a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Concesión de préstamos al sector público a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Concesión de préstamos a la República',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Concesión de préstamos a entes descentralizados sin fines empresariales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Concesión de préstamos a instituciones de protección social',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Concesión de préstamos a entes descentralizados con fines empresariales petroleros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '02', 'subspecific' => '05',
                'denomination' => 'Concesión de préstamos a entes descentralizados con fines empresariales ' .
                                  'no petroleros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '02', 'subspecific' => '06',
                'denomination' => 'Concesión de préstamos a entes descentralizados financieros bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '02', 'subspecific' => '07',
                'denomination' => 'Concesión de préstamos a entes descentralizados financieros no bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '02', 'subspecific' => '08',
                'denomination' => 'Concesión de préstamos al Poder Estadal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '02', 'subspecific' => '09',
                'denomination' => 'Concesión de préstamos al Poder Municipal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Concesión de préstamos al sector externo a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Concesión de préstamos a instituciones sin fines de lucro ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Concesión de préstamos a gobiernos extranjeros ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '04', 'specific' => '03', 'subspecific' => '03',
                'denomination' => 'Concesión de préstamos a organismos internacionales ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de disponibilidades',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento en caja',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '05', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento en bancos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '05', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Incremento en bancos públicos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '05', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Incremento en bancos privados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '05', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Incremento en bancos del exterior',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '05', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Incremento de inversiones temporales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de cuentas por cobrar a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de cuentas comerciales por cobrar a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '06', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de rentas por recaudar a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '06', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Incremento de deudas por rendir ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '06', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Incremento de deudas por rendir de fondos en avance',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '06', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Incremento de deudas por rendir de fondos en anticipo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '06', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Incremento de otras cuentas por cobrar a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '07', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de efectos por cobrar a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '07', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de efectos comerciales por cobrar a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '07', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Incremento de otros efectos por cobrar a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '08', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de cuentas por cobrar a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '08', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de cuentas comerciales por cobrar a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '08', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de rentas por recaudar a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '08', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Incremento de otras cuentas por cobrar a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '09', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de efectos por cobrar a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '09', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de efectos comerciales por cobrar a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '09', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Incremento de otros efectos por cobrar a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '10', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de fondos en avance, en anticipos y en fideicomiso',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '10', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de fondos en avance',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '10', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de fondos en anticipos ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '10', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Incremento de fondos en fideicomiso',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '10', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Incremento de anticipos a proveedores  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '10', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Incremento de anticipos a contratistas por contratos de corto plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '10', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Incremento de anticipos a contratistas por contratos de mediano y largo plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '11', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de activos diferidos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '11', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de gastos a corto plazo pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '11', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Incremento de intereses de la deuda pública interna a corto plazo pagados ' .
                                  'por anticipado ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '11', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Incremento de intereses de la deuda pública externa a corto plazo pagados ' .
                                  'por anticipado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '11', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Incremento de otros intereses a corto plazo pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '11', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Incremento de débitos por apertura de carta de crédito a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '11', 'specific' => '01', 'subspecific' => '99',
                'denomination' => 'Incremento de otros gastos a corto plazo pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '11', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de depósitos otorgados en garantía a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '11', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Incremento de otros activos diferidos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '12', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de activos diferidos a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '12', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de gastos a mediano y largo plazo pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '12', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Incremento de intereses de la deuda pública interna a largo plazo pagados ' .
                                  'por anticipado ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '12', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Incremento de intereses de la deuda pública externa a largo plazo pagados ' .
                                  'por anticipado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '12', 'specific' => '01', 'subspecific' => '08',
                'denomination' => 'Incremento de otros intereses a mediano y largo plazo pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '12', 'specific' => '01', 'subspecific' => '99',
                'denomination' => 'Incremento de otros gastos a mediano y largo plazo pagados por anticipado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '12', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de depósitos otorgados en garantía a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '12', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Incremento de otros activos diferidos a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '13', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento del Fondo de Estabilización Macroeconómica (FEM)',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '13', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento del Fondo de Estabilización Macroeconómica (FEM) de la República',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '13', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento del Fondo de Estabilización Macroeconómica (FEM) del Poder Estadal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '13', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Incremento del Fondo de Estabilización Macroeconómica (FEM) del Poder Municipal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '14', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento  del Fondo de Ahorro Intergeneracional',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '14', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento  del Fondo de Ahorro Intergeneracional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Impuesto a las transacciones financieras',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '30', 'subspecific' => '00',
                'denomination' => 'Retribución al personal de reserva',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '16', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento del Fondo de Aportes del Sector Público ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '16', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento del Fondo de Aportes del Sector Público ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '20', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de otros activos financieros circulantes',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '20', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de otros activos financieros circulantes',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '21', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Incremento de otros activos financieros no circulantes',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '21', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Incremento de activos en gestión judicial a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '21', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Incremento de títulos y otros valores de la deuda pública en litigio a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '21', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Incremento de otros activos financieros no circulantes',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '99', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Otros activos financieros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '05', 'generic' => '99', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Otros activos financieros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '06', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'GASTOS DE DEFENSA Y SEGURIDAD DEL ESTADO',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '06', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Gastos de defensa y seguridad del Estado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '06', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Gastos de defensa y seguridad del Estado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'TRANSFERENCIAS Y DONACIONES',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Transferencias y donaciones corrientes internas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Transferencias corrientes internas al sector privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Pensiones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Jubilaciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Becas escolares',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Becas universitarias en el país',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '05',
                'denomination' => 'Becas de perfeccionamiento profesional en el país',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '06',
                'denomination' => 'Becas para estudios en el extranjero',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '07',
                'denomination' => 'Otras becas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '08',
                'denomination' => 'Previsión por accidentes de trabajo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '09',
                'denomination' => 'Aguinaldos al personal pensionado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '10',
                'denomination' => 'Aportes a caja de ahorro del personal pensionado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '11',
                'denomination' => 'Aportes a los servicios de salud, accidentes personales y gastos funerarios ' .
                                  'del personal pensionado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '12',
                'denomination' => 'Otras subvenciones socio - económicas del personal pensionado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '13',
                'denomination' => 'Aguinaldos al personal jubilado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '14',
                'denomination' => 'Aportes a caja de ahorro del personal jubilado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '15',
                'denomination' => 'Aportes a los servicios de salud, accidentes personales y gastos funerarios ' .
                                  'del personal jubilado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '16',
                'denomination' => 'Otras subvenciones socio - económicas del personal jubilado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '30',
                'denomination' => 'Incapacidad temporal sin hospitalización ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '31',
                'denomination' => 'Incapacidad temporal con hospitalización ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '32',
                'denomination' => 'Reposo por maternidad ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '33',
                'denomination' => 'Indemnización por paro forzoso ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '34',
                'denomination' => 'Otros tipos de incapacidad temporal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '35',
                'denomination' => 'Indemnización por comisión por pensiones ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '36',
                'denomination' => 'Indemnización por comisión por cesantía ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '37',
                'denomination' => 'Incapacidad parcial ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '38',
                'denomination' => 'Invalidez',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '39',
                'denomination' => 'Pensiones por vejez, viudez y orfandad ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '40',
                'denomination' => 'Indemnización por cesantía ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '41',
                'denomination' => 'Otras pensiones y demÃ¡s prestaciones en dinero',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '42',
                'denomination' => 'Incapacidad parcial por accidente común',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '43',
                'denomination' => 'Incapacidad parcial por enfermedades profesionales ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '44',
                'denomination' => 'Incapacidad parcial por accidente de trabajo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '45',
                'denomination' => 'Indemnización única por invalidez ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '46',
                'denomination' => 'Indemnización única por vejez ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '47',
                'denomination' => 'Sobrevivientes por enfermedad común ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '48',
                'denomination' => 'Sobrevivientes por accidente común ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '49',
                'denomination' => 'Sobrevivientes por enfermedades profesionales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '50',
                'denomination' => 'Sobrevivientes por accidentes de trabajo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '51',
                'denomination' => 'Indemnizaciones por conmutación de renta ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '52',
                'denomination' => 'Indemnizaciones por conmutación de pensiones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '53',
                'denomination' => 'Indemnizaciones por comisión de renta',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '54',
                'denomination' => 'Asignación por nupcias ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '55',
                'denomination' => 'Asignación por funeraria ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '56',
                'denomination' => 'Otras asignaciones ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '70',
                'denomination' => 'Subsidios educacionales al sector privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '71',
                'denomination' => 'Subsidios a universidades privadas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '72',
                'denomination' => 'Subsidios culturales al sector privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '73',
                'denomination' => 'Subsidios a instituciones benéficas privadas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '74',
                'denomination' => 'Subsidios a centros de empleados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '75',
                'denomination' => 'Subsidios a organismos laborales y gremiales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '76',
                'denomination' => 'Subsidios a entidades religiosas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '77',
                'denomination' => 'Subsidios a entidades deportivas y recreativas de carÃ¡cter privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '78',
                'denomination' => 'Subsidios científicos al sector privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '79',
                'denomination' => 'Subsidios a cooperativas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '80',
                'denomination' => 'Subsidios a empresas privadas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '01', 'subspecific' => '99',
                'denomination' => 'Otras transferencias corrientes internas al sector privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Donaciones corrientes internas al sector privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Donaciones corrientes a personas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Donaciones corrientes a instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Transferencias corrientes internas al sector público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Transferencias corrientes a la República',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Transferencias corrientes a entes descentralizados sin fines empresariales ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '03',
                'denomination' => 'Transferencias corrientes a entes descentralizados sin fines empresariales ' .
                                  'para atender beneficios de la seguridad social',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '04',
                'denomination' => 'Transferencias corrientes a instituciones de protección social ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '05',
                'denomination' => 'Transferencias corrientes a instituciones de protección social para atender ' .
                                  'beneficios de la seguridad social',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '06',
                'denomination' => 'Transferencias corrientes a entes descentralizados con fines empresariales ' .
                                  'petroleros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '07',
                'denomination' => 'Transferencias corrientes a entes descentralizados con fines empresariales ' .
                                  'no petroleros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '08',
                'denomination' => 'Transferencias corrientes a entes descentralizados financieros bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '09',
                'denomination' => 'Transferencias corrientes a entes descentralizados financieros no bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '10',
                'denomination' => 'Transferencias corrientes al Poder Estadal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '11',
                'denomination' => 'Transferencias corrientes  al Poder Municipal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '13',
                'denomination' => 'Subsidios otorgados por normas externas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '14',
                'denomination' => 'Incentivos otorgados por normas externas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '15',
                'denomination' => 'Subsidios otorgados por precios políticos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '16',
                'denomination' => 'Subsidios de costos sociales por normas externas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Donaciones corrientes internas al sector público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '04', 'subspecific' => '01',
                'denomination' => 'Donaciones corrientes a la República',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '04', 'subspecific' => '02',
                'denomination' => 'Donaciones corrientes a entes descentralizados sin fines empresariales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '04', 'subspecific' => '03',
                'denomination' => 'Donaciones corrientes a instituciones de protección social',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '04', 'subspecific' => '04',
                'denomination' => 'Donaciones corrientes a entes descentralizados con fines empresariales petroleros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '04', 'subspecific' => '05',
                'denomination' => 'Donaciones corrientes a entes descentralizados con fines empresariales ' .
                                  'no petroleros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '04', 'subspecific' => '06',
                'denomination' => 'Donaciones corrientes a entes descentralizados financieros bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '04', 'subspecific' => '07',
                'denomination' => 'Donaciones corrientes a entes descentralizados financieros no bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '04', 'subspecific' => '08',
                'denomination' => 'Donaciones corrientes al Poder Estadal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '04', 'subspecific' => '09',
                'denomination' => 'Donaciones corrientes  al Poder Municipal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Transferencias y donaciones corrientes al exterior',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Transferencias corrientes al exterior',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '02', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Becas de capacitación e investigación en el exterior',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '02', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Transferencias corrientes a instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '02', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Transferencias corrientes a gobiernos extranjeros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '02', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Transferencias corrientes a organismos internacionales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Donaciones corrientes al exterior',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '02', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Donaciones corrientes a personas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '02', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Donaciones corrientes a instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '02', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Donaciones corrientes a gobiernos extranjeros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '02', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Donaciones corrientes a organismos internacionales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Transferencias y donaciones de capital internas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Transferencias de capital internas al sector privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Transferencias de capital a personas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Transferencias de capital a instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Transferencias de capital a empresas privadas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Donaciones de capital internas al sector privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Donaciones de capital a personas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Donaciones de capital a instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Transferencias de capital internas al sector público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Transferencias de capital a la República',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Transferencias de capital a entes descentralizados sin fines empresariales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '03', 'subspecific' => '03',
                'denomination' => 'Transferencias de capital a instituciones de protección social',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '03', 'subspecific' => '04',
                'denomination' => 'Transferencias de capital a entes descentralizados con fines empresariales ' .
                                  'petroleros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '03', 'subspecific' => '05',
                'denomination' => 'Transferencias de capital a entes descentralizados con fines empresariales ' .
                                  'no petroleros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '03', 'subspecific' => '06',
                'denomination' => 'Transferencias de capital a entes descentralizados financieros bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '03', 'subspecific' => '07',
                'denomination' => 'Transferencias de capital a entes descentralizados financieros no bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '03', 'subspecific' => '08',
                'denomination' => 'Transferencias de capital al Poder Estadal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '03', 'subspecific' => '09',
                'denomination' => 'Transferencias de capital al Poder Municipal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Donaciones de capital internas al sector público ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '04', 'subspecific' => '01',
                'denomination' => 'Donaciones de capital a la República',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '04', 'subspecific' => '02',
                'denomination' => 'Donaciones de capital a entes descentralizados sin fines empresariales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '04', 'subspecific' => '03',
                'denomination' => 'Donaciones de capital a instituciones de protección social',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '04', 'subspecific' => '04',
                'denomination' => 'Donaciones de capital a entes descentralizados con fines empresariales petroleros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '04', 'subspecific' => '05',
                'denomination' => 'Donaciones de capital a entes descentralizados con fines empresariales ' .
                                  'no petroleros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '04', 'subspecific' => '06',
                'denomination' => 'Donaciones de capital a entes descentralizados financieros bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '04', 'subspecific' => '07',
                'denomination' => 'Donaciones de capital a entes descentralizados financieros no bancarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '04', 'subspecific' => '08',
                'denomination' => 'Donaciones de capital al Poder Estadal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '04', 'subspecific' => '09',
                'denomination' => 'Donaciones de capital al Poder Municipal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Transferencias y donaciones de capital al exterior',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Transferencias de capital al exterior',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '04', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Transferencias de capital a personas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '04', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Transferencias de capital a instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '04', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Transferencias de capital a gobiernos extranjeros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '04', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Transferencias de capital a organismos internacionales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Donaciones de capital al exterior',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '04', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Donaciones de capital a personas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '04', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Donaciones de capital a instituciones sin fines de lucro',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '04', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Donaciones de capital a gobiernos extranjeros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '04', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Donaciones de capital a organismos internacionales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Situado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Situado Constitucional',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '05', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Situado Estadal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '05', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Situado Municipal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '01', 'specific' => '03', 'subspecific' => '99',
                'denomination' => 'Otras transferencias corrientes internas al sector público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '05', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Situado Estadal a Municipal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Subsidio de Régimen Especial',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Subsidio de Régimen Especial',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '07', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Subsidio de capitalidad',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '07', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Subsidio de capitalidad',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '03', 'specific' => '03', 'subspecific' => '99',
                'denomination' => 'Otras transferencias de capital internas al sector público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '08', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones Económicas Especiales (LAEE)',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '08', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones Económicas Especiales (LAEE) Estadal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '08', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Asignaciones Económicas Especiales (LAEE) Estadal a Municipal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '09', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Aportes a los Estados y Municipios por transferencia de servicios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '09', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Aporte a los Estados por transferencia de servicios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '10', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Fondo Intergubernamental para la Descentralización (FIDES)',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '10', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Fondo Intergubernamental para la Descentralización (FIDES)',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'OTROS GASTOS',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Depreciación y amortización ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Depreciación  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Depreciación de edificios e instalaciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Depreciación de maquinaria y demás equipos de construcción, campo, ' .
                                  'industria y taller ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Depreciación de equipos de transporte, tracción y elevación ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Depreciación de equipos de comunicaciones y de señalamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '01', 'subspecific' => '05',
                'denomination' => 'Depreciación de equipos médico - quirúrgicos, dentales y de veterinaria',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '01', 'subspecific' => '06',
                'denomination' => 'Depreciación de equipos cientí­ficos, religiosos, de enseñanza y recreación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '01', 'subspecific' => '07',
                'denomination' => 'Depreciación de equipos para la seguridad pública',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '01', 'subspecific' => '08',
                'denomination' => 'Depreciación de máquinas, muebles y demás equipos de oficina y alojamiento',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '01', 'subspecific' => '09',
                'denomination' => 'Depreciación  de semovientes',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '01', 'subspecific' => '99',
                'denomination' => 'Depreciación  de otros bienes de uso',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Amortización ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Amortización de marcas de fÃ¡brica y patentes de invención',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Amortización de derechos de autor',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Amortización de gastos de organización',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Amortización de paquetes y programas de computación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '02', 'subspecific' => '05',
                'denomination' => 'Amortización de estudios y proyectos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '01', 'specific' => '02', 'subspecific' => '99',
                'denomination' => 'Amortización de otros activos intangibles ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Intereses por operaciones  financieras ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Intereses por depósitos internos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Intereses por títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Intereses por otros financiamientos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Gastos por operaciones de seguro ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Gastos de siniestros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Gastos de operaciones de reaseguros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '03', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otros gastos de operaciones de seguro',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Pérdida en operaciones de los servicios básicos ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Pérdidas en el proceso de distribución de los servicios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '04', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Otras pérdidas en operación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Obligaciones en el ejercicio vigente ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Devoluciones de cobros indebidos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '05', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Devoluciones y reintegros diversos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '05', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Indemnizaciones diversas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Pérdidas ajenas a la operación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Pérdidas en inventarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '06', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Pérdidas en operaciones cambiarias',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '06', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Pérdidas en ventas de activos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '06', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Pérdidas por cuentas incobrables',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '06', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Participación en pérdidas de otras empresas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '06', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Pérdidas por auto-seguro',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '06', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Impuestos directos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '06', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Intereses de mora ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '06', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Reservas técnicas ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '07', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Descuentos, bonificaciones y devoluciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '07', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Descuentos sobre ventas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '07', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Bonificaciones por ventas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '07', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Devoluciones por ventas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '07', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Devoluciones por primas de seguro',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '08', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Indemnizaciones y sanciones pecuniarias',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '08', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Indemnizaciones por daños y perjuicios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '08', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Indemnizaciones por daños y perjuicios ocasionados por organismos de la ' .
                                  'República, del Poder Estadal y del Poder Municipal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '08', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Indemnizaciones por daños y perjuicios ocasionados por entes descentralizados ' .
                                  'sin fines empresariales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '08', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Sanciones pecuniarias',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '08', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Sanciones pecuniarias ocasionadas por organismos de la República, del Poder ' .
                                  'Estadal y del Poder Municipal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '08', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Sanciones pecuniarias ocasionadas por entes descentralizados sin fines ' .
                                  'empresariales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '99', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Otros gastos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '99', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Otros gastos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'ASIGNACIONES NO DISTRIBUIDAS',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones  no distribuidas de la Asamblea Nacional ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones  no distribuidas de la Asamblea Nacional ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones no distribuidas de la Contraloría General de la República',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones no distribuidas de la Contraloría General de la República',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones no distribuidas del Consejo Nacional Electoral',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones no distribuidas del Consejo Nacional Electoral',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones no distribuidas del Tribunal Supremo de Justicia',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones no distribuidas del Tribunal Supremo de Justicia',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones no distribuidas del Ministerio Público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones no distribuidas del Ministerio Público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones no distribuidas de la Defensorí­a del Pueblo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones no distribuidas de la Defensoría del Pueblo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '07', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones no distribuidas del Consejo Moral Republicano ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '07', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones no distribuidas del Consejo Moral Republicano',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '08', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Reestructuración de organismos del sector público ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '08', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Reestructuración de organismos del sector público ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '09', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Fondo de apoyo al trabajador y su grupo familiar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '09', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Fondo de apoyo al trabajador y su grupo familiar de la  Administración ' .
                                  'Pública Nacional',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '09', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Fondo de apoyo al trabajador y su grupo familiar de los Estados y Municipios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '10', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Reforma de la seguridad social',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '10', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Reforma de la seguridad social',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '11', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Emergencias en el territorio nacional',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '11', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Emergencias en el territorio nacional',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '12', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Fondo para la cancelación de pasivos laborales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '12', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Fondo para la cancelación de pasivos laborales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '13', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Fondo para la cancelación de deuda por servicios de electricidad, ' .
                                  'teléfono, aseo, agua y condominio',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '13', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Fondo para la cancelación de deuda por servicios de electricidad, ' .
                                  'teléfono, aseo, agua y condominio, de los organismos de la ' .
                                  'Administración Central',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '13', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Fondo para la cancelación de deuda por servicios de electricidad, ' .
                                  'teléfono, aseo, agua y condominio, de los organismos de la ' .
                                  'Administración Descentralizada Nacional',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '14', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Fondo para remuneraciones, pensiones y jubilaciones y otras retribuciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '14', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Fondo para remuneraciones, pensiones y jubilaciones y otras retribuciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '15', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Fondo para atender compromisos generados de la Ley Orgánica del Trabajo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '15', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Fondo para atender compromisos generados de la Ley Orgánica del Trabajo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '16', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones para cancelar compromisos pendientes de ejercicios anteriores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '16', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones para cancelar compromisos pendientes de ejercicios anteriores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '17', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones para cancelar la deuda Fogade - Ministerio competente en ' .
                                  'materia de Finanzas - Banco Central de Venezuela (BCV)',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '17', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones para cancelar la deuda Fogade - Ministerio competente en ' .
                                  'materia de Finanzas - Banco Central de Venezuela (BCV)',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '18', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones para atender los gastos de la referenda y elecciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '18', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones para atender los gastos de la referenda y elecciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '19', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones para atender los gastos por honorarios profesionales de ' .
                                  'bufetes internacionales, costas y costos judiciales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '19', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones para atender los gastos por honorarios profesionales de ' .
                                  'bufetes internacionales, costas y costos judiciales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '20', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Fondo para atender compromisos generados por la contratación colectiva',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '20', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Fondo para atender compromisos generados por la contratación colectiva',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '21', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Programa social especial',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '21', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Programa social especial',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '22', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones para programas y proyectos financiados con recursos de ' .
                                  'organismos multilaterales y/o bilaterales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '22', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones para programas y proyectos financiados con recursos de ' .
                                  'organismos multilaterales y/o bilaterales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '23', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignación para facilitar la preparación de proyectos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '23', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignación para facilitar la preparación de proyectos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '24', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Programas de inversión para las entidades estadales, municipalidades ' .
                                  'y otras instituciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '24', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Programas de inversión para las entidades estadales, municipalidades ' .
                                  'y otras instituciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '25', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Cancelación de compromisos ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '25', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Cancelación de compromisos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'SERVICIO DE LA DEUDA PÚBLICA ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública interna a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública interna a corto plazo de tí­tulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Amortización de la deuda pública interna a corto plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Amortización de la deuda pública interna a corto plazo de letras del tesoro',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Intereses de la deuda pública interna a corto plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna a corto plazo ' .
                                  'de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '01', 'subspecific' => '05',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna a corto plazo ' .
                                  'de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '01', 'subspecific' => '06',
                'denomination' => 'Descuentos en colocación de títulos y valores de la deuda pública interna ' .
                                  'a  corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '01', 'subspecific' => '07',
                'denomination' => 'Descuentos en colocación de letras del tesoro a corto plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública interna por préstamos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos del ' .
                                  'sector privado a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos de la ' .
                                  'República a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados sin fines empresariales a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos de ' .
                                  'instituciones de protección social a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '05',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados con fines empresariales petroleros a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '06',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados con fines empresariales no petroleros a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '07',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados financieros bancarios a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '08',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados financieros no bancarios a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '09',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos del Poder ' .
                                  'Estadal a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '10',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos del ' .
                                  'Poder Municipal a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '11',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos del ' .
                                  'sector privado a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '12',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos de la ' .
                                  'República a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '13',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados sin fines empresariales a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '14',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos de ' .
                                  'instituciones de protección social a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '15',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados con fines empresariales petroleros a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '16',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados con fines empresariales no petroleros a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '17',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados financieros bancarios a corto plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '18',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados financieros no bancarios a corto plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '19',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos del Poder ' .
                                  'Estadal a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '20',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos del Poder ' .
                                  'Municipal a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '21',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos del sector privado a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '22',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos de la República a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '23',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados sin fines empresariales a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '24',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos de instituciones de protección social a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '25',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados con fines empresariales petroleros ' .
                                  'a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '26',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados con fines empresariales no petroleros ' .
                                  'a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '27',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados financieros bancarios a corto plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '28',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados financieros no bancarios a corto plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '29',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos del Poder Estadal a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '30',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos del Poder Municipal a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '31',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos del sector privado a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '32',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos de la República a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '33',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados sin fines empresariales a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '34',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos de instituciones de protección social a corto  plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '35',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados con fines empresariales petroleros ' .
                                  'a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '36',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados con fines empresariales no petroleros ' .
                                  'a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '37',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados financieros bancarios a corto plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '38',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados financieros no bancarios a corto  plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '39',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos del Poder Estadal a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '02', 'subspecific' => '40',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos del Poder Municipal a corto  plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública interna indirecta por préstamos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Amortización de la deuda pública interna indirecta por préstamos ' .
                                  'recibidos del sector privado a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Amortización de la deuda pública interna indirecta por préstamos ' .
                                  'recibidos del sector público a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '03', 'subspecific' => '03',
                'denomination' => 'Intereses de la deuda pública interna indirecta por préstamos recibidos ' .
                                  'del sector privado a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '03', 'subspecific' => '04',
                'denomination' => 'Intereses de la deuda pública interna indirecta por préstamos recibidos ' .
                                  'del sector público a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '03', 'subspecific' => '05',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna indirecta por ' .
                                  'préstamos recibidos del sector privado a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '03', 'subspecific' => '06',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna indirecta por ' .
                                  'préstamos recibidos del sector público a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '03', 'subspecific' => '07',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna indirecta por ' .
                                  'préstamos recibidos del sector privado a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '01', 'specific' => '03', 'subspecific' => '08',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna indirecta por ' .
                                  'préstamos recibidos del sector público a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública interna a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública interna a largo plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Amortización de la deuda pública interna a largo plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Amortización de la deuda pública interna a largo plazo de letras del tesoro',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Intereses de la deuda pública interna a largo plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna a largo plazo ' .
                                  'de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '01', 'subspecific' => '05',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna a largo plazo ' .
                                  'de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '01', 'subspecific' => '06',
                'denomination' => 'Descuentos en colocación de títulos y valores de la deuda pública ' .
                                  'interna a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '01', 'subspecific' => '07',
                'denomination' => 'Descuentos en colocación de letras del tesoro a largo plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública interna por préstamos a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos del ' .
                                  'sector privado a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos de la ' .
                                  'República a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados sin fines empresariales a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos de ' .
                                  'instituciones de protección social a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '05',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados con fines empresariales petroleros a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '06',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados con fines empresariales no petroleros a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '07',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados financieros bancarios a largo plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '08',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados financieros no bancarios a largo plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '09',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos del ' .
                                  'Poder Estadal a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '10',
                'denomination' => 'Amortización de la deuda pública interna por préstamos recibidos del ' .
                                  'Poder Municipal a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '11',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos del ' .
                                  'sector privado a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '12',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos de la ' .
                                  'República a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '13',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados sin fines empresariales a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '14',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos de instituciones ' .
                                  'de protección social a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '15',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados con fines empresariales petroleros a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '16',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados con fines empresariales no petroleros a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '17',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados financieros bancarios a largo plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '18',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos de entes ' .
                                  'descentralizados financieros no bancarios a largo plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '19',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos del Poder Estadal ' .
                                  'a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '20',
                'denomination' => 'Intereses de la deuda pública interna por préstamos recibidos del Poder ' .
                                  'Municipal a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '21',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos recibidos ' .
                                  'del sector privado a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '22',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos recibidos ' .
                                  'de la República a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '23',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados sin fines empresariales a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '24',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos de instituciones de protección social a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '25',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados con fines empresariales petroleros ' .
                                  'a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '26',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados con fines empresariales no petroleros ' .
                                  'a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '27',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados financieros bancarios a largo plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '28',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados financieros no bancarios a largo plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '29',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos del Poder Estadal a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '30',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna por préstamos ' .
                                  'recibidos del Poder Municipal a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '31',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos del sector privado a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '32',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos de la República a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '33',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados sin fines empresariales a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '34',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos de instituciones de protección social a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '35',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados con fines empresariales petroleros ' .
                                  'a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '36',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados con fines empresariales no ' .
                                  'petroleros a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '37',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados financieros bancarios a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '38',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos de entes descentralizados financieros no bancarios a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '39',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos del Poder Estadal a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '02', 'subspecific' => '40',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna por préstamos ' .
                                  'recibidos del Poder Municipal a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública interna indirecta a largo plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Amortización de la deuda pública interna indirecta a largo plazo de ' .
                                  'títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Intereses de la deuda pública interna indirecta a largo plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '03', 'subspecific' => '03',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna indirecta a largo ' .
                                  'plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '03', 'subspecific' => '04',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna indirecta a largo ' .
                                  'plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '03', 'subspecific' => '05',
                'denomination' => 'Descuentos en colocación de títulos y valores de la deuda pública interna ' .
                                  'indirecta de largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública interna indirecta por préstamos a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '04', 'subspecific' => '01',
                'denomination' => 'Amortización de la deuda pública interna indirecta por préstamos recibidos ' .
                                  'del sector privado a largo plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '04', 'subspecific' => '02',
                'denomination' => 'Amortización de la deuda pública interna indirecta por préstamos recibidos ' .
                                  'del sector público a largo plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '04', 'subspecific' => '03',
                'denomination' => 'Intereses de la deuda pública interna indirecta por préstamos recibidos ' .
                                  'del sector privado a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '04', 'subspecific' => '04',
                'denomination' => 'Intereses de la deuda pública interna indirecta por préstamos recibidos ' .
                                  'del sector público a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '04', 'subspecific' => '05',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna indirecta por ' .
                                  'préstamos recibidos del sector privado a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '04', 'subspecific' => '06',
                'denomination' => 'Intereses por mora y multas de la deuda pública interna indirecta por ' .
                                  'préstamos recibidos del sector público a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '04', 'subspecific' => '07',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna indirecta por ' .
                                  'préstamos recibidos del sector privado a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '02', 'specific' => '04', 'subspecific' => '08',
                'denomination' => 'Comisiones y otros gastos de la deuda pública interna indirecta por ' .
                                  'préstamos recibidos del sector público a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública externa a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública externa a corto plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Amortización de la deuda pública externa a corto plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Intereses de la deuda pública externa a corto plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa a corto plazo de ' .
                                  'títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa a corto plazo de ' .
                                  'títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '01', 'subspecific' => '05',
                'denomination' => 'Descuentos en colocación de títulos y valores de la deuda pública externa ' .
                                  'a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública externa por préstamos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Amortización de la deuda pública externa por préstamos recibidos de ' .
                                  'gobiernos extranjeros a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Amortización de la deuda pública externa por préstamos recibidos de ' .
                                  'organismos internacionales a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Amortización de la deuda pública externa por préstamos recibidos de ' .
                                  'instituciones financieras externas a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Amortización de la deuda pública externa por préstamos recibidos de ' .
                                  'proveedores de bienes y servicios externos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '05',
                'denomination' => 'Intereses de la deuda pública externa por préstamos  recibidos de ' .
                                  'gobiernos extranjeros a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '06',
                'denomination' => 'Intereses de la deuda pública externa por préstamos  recibidos de ' .
                                  'organismos internacionales a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '07',
                'denomination' => 'Intereses de la deuda pública externa por préstamos  recibidos de ' .
                                  'instituciones financieras externas a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '08',
                'denomination' => 'Intereses de la deuda pública externa por préstamos  recibidos de ' .
                                  'proveedores de bienes y servicios externos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '09',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa por préstamos ' .
                                  'recibidos de gobiernos extranjeros a corto plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '10',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa por préstamos ' .
                                  'recibidos  de organismos internacionales a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '11',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa por préstamos ' .
                                  'recibidos de instituciones financieras externas a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '12',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa por préstamos ' .
                                  'recibidos de proveedores de bienes y servicios externos a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '13',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa por préstamos  ' .
                                  'recibidos de gobiernos extranjeros a corto plazo  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '14',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa por préstamos  ' .
                                  'recibidos  de organismos internacionales a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '15',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa por préstamos  ' .
                                  'recibidos de instituciones financieras externas a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '02', 'subspecific' => '16',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa por préstamos ' .
                                  'recibidos de proveedores de bienes y servicios externos a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública externa indirecta por préstamos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Amortización de la deuda pública externa indirecta por préstamos recibidos ' .
                                  'de gobiernos extranjeros a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Amortización de la deuda pública externa indirecta por préstamos recibidos ' .
                                  'de organismos internacionales a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '03',
                'denomination' => 'Amortización de la deuda pública externa indirecta por préstamos recibidos ' .
                                  'de instituciones financieras externas a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '04',
                'denomination' => 'Amortización de la deuda pública externa indirecta por préstamos  recibidos ' .
                                  'de proveedores de bienes y servicios externos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '05',
                'denomination' => 'Intereses de la deuda pública externa indirecta por préstamos recibidos de ' .
                                  'gobiernos extranjeros a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '06',
                'denomination' => 'Intereses de la deuda pública externa indirecta por préstamos recibidos de ' .
                                  'organismos internacionales a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '07',
                'denomination' => 'Intereses de la deuda pública externa indirecta por préstamos recibidos de ' .
                                  'instituciones financieras externas a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '08',
                'denomination' => 'Intereses de la deuda pública externa indirecta por préstamos recibidos de ' .
                                  'proveedores de bienes y servicios externos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '09',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa indirecta por ' .
                                  'préstamos  recibidos de gobiernos extranjeros a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '10',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa indirecta por ' .
                                  'préstamos recibidos de organismos internacionales a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '11',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa indirecta por ' .
                                  'préstamos recibidos de instituciones financieras externas a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '12',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa indirecta por ' .
                                  'préstamos  recibidos de proveedores de bienes y servicios externos a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '13',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa indirecta por ' .
                                  'préstamos  recibidos de gobiernos extranjeros a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '14',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa indirecta por ' .
                                  'préstamos recibidos de organismos internacionales a corto plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '15',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa indirecta por ' .
                                  'préstamos  recibidos de instituciones financieras externas a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '03', 'specific' => '03', 'subspecific' => '16',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa indirecta por ' .
                                  'préstamos recibidos de proveedores de bienes y servicios externos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública externa a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública externa a largo plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Amortización de la deuda pública externa a largo plazode títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Intereses de la deuda pública externa a largo plazode títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa a largo plazo de ' .
                                  'títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa a largo plazo de ' .
                                  'títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '01', 'subspecific' => '05',
                'denomination' => 'Descuentos en colocación de títulos y valores de la deuda pública externa ' .
                                  'a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública externa por préstamos a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Amortización de la deuda pública externa por préstamos recibidos de ' .
                                  'gobiernos extranjeros a  largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Amortización de la deuda pública externa por préstamos  recibidos de ' .
                                  'organismos internacionales a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Amortización de la deuda pública externa por préstamos recibidos de ' .
                                  'instituciones financieras externas a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '04',
                'denomination' => 'Amortización de la deuda pública externa por préstamos recibidos de ' .
                                  'proveedores de bienes y servicios externos  a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '05',
                'denomination' => 'Intereses de la deuda pública externa por préstamos recibidos de ' .
                                  'gobiernos extranjeros  a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '06',
                'denomination' => 'Intereses de la deuda pública externa por préstamos recibidos de ' .
                                  'organismos internacionales a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '07',
                'denomination' => 'Intereses de la deuda pública externa por préstamos recibidos de ' .
                                  'instituciones financieras externas a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '08',
                'denomination' => 'Intereses de la deuda pública externa por préstamos recibidos de ' .
                                  'proveedores de bienes y servicios externos  a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '09',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa por préstamos  ' .
                                  'recibidos de gobiernos extranjeros  a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '10',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa por préstamos ' .
                                  'recibidos de organismos internacionales a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '11',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa por préstamos ' .
                                  'recibidos de instituciones financieras externas  a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '12',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa por préstamos ' .
                                  'recibidos de proveedores de bienes y servicios externos  a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '13',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa por préstamos ' .
                                  'recibidos de gobiernos extranjeros  a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '14',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa por préstamos ' .
                                  'recibidos de organismos internacionales a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '15',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa por préstamos ' .
                                  'recibidos de instituciones financieras externas  a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '02', 'subspecific' => '16',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa por préstamos  ' .
                                  'recibidos de proveedores de bienes y servicios externos  a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública externa indirecta a largo plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '03', 'subspecific' => '01',
                'denomination' => 'Amortización de la deuda pública externa indirecta a largo plazo de ' .
                                  'títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '03', 'subspecific' => '02',
                'denomination' => 'Intereses de la deuda pública externa indirecta a largo plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '03', 'subspecific' => '03',
                'denomination' => 'Intereses por mora y multas de la deuda pública externa indirecta a largo ' .
                                  'plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '03', 'subspecific' => '04',
                'denomination' => 'Comisiones y otros gastos de la deuda pública externa indirecta a largo ' .
                                  'plazo de títulos y valores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '03', 'subspecific' => '05',
                'denomination' => 'Descuentos en colocación de títulos y valores de la deuda pública externa ' .
                                  'indirecta a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública externa indirecta por préstamos a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '01',
                'denomination' => 'Amortización de la deuda pública externa indirecta por préstamos recibidos ' .
                                  'de gobiernos extranjeros a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '02',
                'denomination' => 'Amortización de la deuda pública externa indirecta por préstamos recibidos ' .
                                  'de organismos internacionales a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '03',
                'denomination' => ' Amortización de la deuda pública externa indirecta por préstamos recibidos ' .
                                  'de instituciones financieras externas a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '04',
                'denomination' => ' Amortización de la deuda pública externa indirecta por préstamos recibidos ' .
                                  'de proveedores de bienes y servicios externos  a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '05',
                'denomination' => 'Intereses de la deuda pública externa indirecta por préstamos recibidos de ' .
                                  'gobiernos extranjeros a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '06',
                'denomination' => 'Intereses de la deuda pública externa indirecta por préstamos recibidos de ' .
                                  'organismos internacionales a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '07',
                'denomination' => 'Intereses de la deuda pública externa indirecta por préstamos recibidos ' .
                                  'de instituciones financieras externas a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '08',
                'denomination' => 'Intereses de la deuda pública externa indirecta por préstamos recibidos ' .
                                  'de proveedores de bienes y servicios externos  a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '09',
                'denomination' => ' Intereses por mora y multas de la deuda pública externa indirecta por ' .
                                  'préstamos recibidos de gobiernos extranjeros a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '10',
                'denomination' => ' Intereses por mora y multas de la deuda pública externa indirecta por ' .
                                  'préstamos recibidos de organismos internacionales a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '11',
                'denomination' => ' Intereses por mora y multas de la deuda pública externa indirecta por ' .
                                  'préstamos recibidos de instituciones financieras externas a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '12',
                'denomination' => ' Intereses por mora y multas de la deuda pública externa indirecta por ' .
                                  'préstamos recibidos de proveedores de bienes y servicios externos a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '13',
                'denomination' => ' Comisiones y otros gastos de la deuda pública externa indirecta por ' .
                                  'préstamos recibidos de gobiernos extranjeros a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '14',
                'denomination' => ' Comisiones y otros gastos de la deuda pública externa indirecta por ' .
                                  'préstamos recibidos de organismos internacionales a largo plazo ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '15',
                'denomination' => ' Comisiones y otros gastos de la deuda pública externa indirecta por ' .
                                  'préstamos  recibidos de instituciones financieras externas a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '04', 'specific' => '04', 'subspecific' => '16',
                'denomination' => ' Comisiones y otros gastos de la deuda pública externa indirecta por ' .
                                  'préstamos  recibidos de proveedores de bienes y servicios externos  a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Reestructuración y/o refinanciamiento de la deuda publica',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución por reestructuración y/o refinanciamiento de la deuda interna ' .
                                  'a largo plazo, en a  corto plazo-',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '05', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución por reestructuración y/o refinanciamiento de la deuda interna ' .
                                  'a corto plazo, en a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '05', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Disminución por reestructuración y/o refinanciamiento de la deuda externa ' .
                                  'a largo plazo, en a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '05', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Disminución por reestructuración y/o refinanciamiento de la deuda externa ' .
                                  'a corto plazo, en a largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '05', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Disminución  de la deuda pública por distribuir',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '05', 'specific' => '05', 'subspecific' => '01',
                'denomination' => 'Disminución  de la deuda pública interna por distribuir   ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '05', 'specific' => '05', 'subspecific' => '02',
                'denomination' => 'Disminución de la deuda pública externa por distribuir    ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Servicio de la deuda pública por obligaciones de ejercicios anteriores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Amortización de la deuda pública de obligaciones pendientes de ejercicios ' .
                                  'anteriores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '06', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Intereses de la deuda pública de obligaciones pendientes de ejercicios anteriores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '06', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Intereses por mora y multas de la deuda pública de obligaciones pendientes ' .
                                  'de ejercicios anteriores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '10', 'generic' => '06', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Comisiones y otros gastos de la deuda pública de obligaciones pendientes ' .
                                  'de ejercicios anteriores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'DISMINUCION DE PASIVOS ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de gastos de personal por pagar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de sueldos,  salarios y otras remuneraciones por pagar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de aportes patronales y retenciones laborales por pagar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de aportes patronales y retenciones laborales por pagar al ' .
                                  'Instituto Venezolano de los Seguros Sociales (IVSS)',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '02', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de aportes patronales y retenciones laborales por pagar al ' .
                                  'Instituto de Previsión Social del Ministerio de Educación (IPASME)',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '02', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Disminución de aportes  patronales  y retenciones laborales por pagar al ' .
                                  'Fondo de Jubilaciones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '02', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Disminución  de aportes patronales y  retenciones laborales por  pagar al ' .
                                  'Fondo de Seguro de Paro Forzoso',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '02', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Disminución  de aportes  patronales  y  retenciones laborales por pagar al ' .
                                  'Fondo de Ahorro Habitacional',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '02', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Disminución  de  aportes patronales y retenciones laborales por pagar al ' .
                                  'seguro de vida, accidentes personales, hospitalización, cirugía, maternidad ' .
                                  '(HCM) y gastos funerarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '02', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Disminución de aportes patronales y retenciones laborales por pagar a ' .
                                  'cajas de ahorro',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '02', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Disminución  de aportes patronales por pagar a organismos de seguridad social',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '02', 'specific' => '09', 'subspecific' => '00',
                'denomination' => 'Disminución  de retenciones  laborales  por  pagar  al  Instituto Nacional ' .
                                  'de Cooperación Educativa (INCE)',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '02', 'specific' => '10', 'subspecific' => '00',
                'denomination' => 'Disminución de retenciones laborales por  pagar por pensión alimenticia',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '02', 'specific' => '98', 'subspecific' => '00',
                'denomination' => 'Disminución de otros aportes legales por pagar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '02', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Disminución de otras retenciones laborales por  pagar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de cuentas y efectos por pagar a proveedores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de cuentas por pagar a proveedores a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '03', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de efectos por pagar a  proveedores a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '03', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Disminución de cuentas por pagar a proveedores a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '03', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Disminución de efectos por pagar a proveedores a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de cuentas y efectos por pagar a contratistas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de cuentas por pagar a contratistas a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de efectos por pagar a contratistas a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '04', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Disminución de cuentas por pagar a contratistas a mediano largo y plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '04', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Disminución de efectos por pagar a contratistas a mediano y plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '05', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de intereses por pagar    ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '05', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de intereses internos por pagar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '05', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de intereses externos por pagar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '06', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de otras cuentas y efectos por pagar a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '06', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de obligaciones de ejercicios anteriores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '06', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de otras cuentas por pagar a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '06', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Disminución de otros efectos por pagar a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '07', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de pasivos diferidos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '07', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de pasivos diferidos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '07', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Disminución de rentas diferidas por recaudar a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '07', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de pasivos diferidos a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '07', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Disminución del rescate de certificados de reintegro tributario',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '07', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Disminución del rescate de bonos de exportación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '07', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Disminución del rescate de bonos en dación de pagos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '08', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de provisiones y reservas técnicas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '08', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de provisiones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '08', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Disminución de provisiones para cuentas incobrables',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '08', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Disminución de provisiones para despidos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '08', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Disminución de provisiones para pérdidas en el inventario',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '08', 'specific' => '01', 'subspecific' => '04',
                'denomination' => 'Disminución de provisiones  para beneficios sociales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '08', 'specific' => '01', 'subspecific' => '99',
                'denomination' => 'Disminución de otras  provisiones',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '08', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de reservas técnicas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '09', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de fondos de terceros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '09', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de depósitos recibidos en garantía',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '09', 'specific' => '99', 'subspecific' => '00',
                'denomination' => 'Disminución de otros fondos de terceros',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '10', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución  de  depósitos  de instituciones financieras',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '10', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de depósitos a la vista',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '10', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Disminución  de  depósitos   de  terceros  a  la  vista  de  organismos  ' .
                                  'del sector público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '10', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Disminución  de depósitos de terceros a la vista de personas naturales y ' .
                                  'jurídicas del sector privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '10', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de depósitos a plazo fijo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '10', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Disminución de depósitos a plazo fijo de organismos del sector público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '10', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Disminución de depósitos a plazo fijo de personas naturales y jurídicas ' .
                                  'del sector privado',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '11', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Obligaciones de ejercicios anteriores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '11', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Devoluciones de cobros indebidos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '11', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Devoluciones y reintegros diversos',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '11', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Indemnizaciones diversas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '11', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Compromisos pendientes de ejercicios anteriores',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '11', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Prestaciones de antigüedad originadas por la aplicación de la Ley Orgánica ' .
                                  'del Trabajo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '98', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de otros pasivos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '98', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de otros pasivos a corto plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '99', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de otros pasivos a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '11', 'generic' => '99', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de otros pasivos a mediano y largo plazo',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '12', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'DISMINUCIÓN DEL PATRIMONIO',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '12', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución del capital  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '12', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución del capital fiscal e institucional',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '12', 'generic' => '01', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de aportes por capitalizar',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '12', 'generic' => '01', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Disminución de dividendos a distribuir',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '12', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de reservas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '12', 'generic' => '02', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de reservas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '12', 'generic' => '02', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de reservas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '12', 'generic' => '03', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Ajuste por inflación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '12', 'generic' => '03', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Ajuste por inflación',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '12', 'generic' => '04', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Disminución de resultados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '12', 'generic' => '04', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Disminución de resultados acumulados',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '12', 'generic' => '04', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Disminución de resultados del ejercicio',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '98', 'generic' => '00', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'RECTIFICACIONES AL PRESUPUESTO',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '98', 'generic' => '01', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Rectificaciones al presupuesto  ',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '98', 'generic' => '01', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Rectificaciones al presupuesto',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '03', 'generic' => '19', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'COMISIONES POR SERVICIOS PARA CUMPLIR CON LOS BENEFICIOS SOCIALES',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '08', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Fondo de Compensación Interterritorial Poder Popular',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '08', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Fondo de Compensación Interterritorial Fortalecimiento Institucional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '06', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Asignaciones Económicas Especiales (LAEE) Apoyo al Fortalecimiento Institucional',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '04', 'generic' => '08', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Equipos  y armamentos de seguridad para custodia y resguardo de personas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '11', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Fondo de Compensación Interterritorial',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '11', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Fondo de Compensación Interterritorial Estadal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '11', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Fondo de Compensación Interterritorial Municipal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '11', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Fondo de Compensación Interterritorial Poder Popular',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '11', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Fondo de Compensación Interterritorial Fortalecimiento Institucional',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '06', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Asignaciones Económicas Especiales (LAEE) Estadal a Municipal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '06', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Asignaciones Económicas Especiales (LAEE) Municipal',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '06', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Asignaciones Económicas Especiales (LAEE) Fondo Nacional de los Consejos Comunales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '08', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Asignaciones Económicas Especiales (LAEE) Municipal',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '08', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Asignaciones Económicas Especiales (LAEE) Fondo Nacional de los Consejos Comunales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '08', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Asignaciones Económicas Especiales (LAEE) Apoyo al Fortalecimiento Institucional',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '08', 'subspecific' => '00',
                'denomination' => 'Aporte patronal a los servicios de salud, accidentes personales y gastos ' .
                                  'funerarios por empleados',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '09', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Aportes a los Estados por transferencia de servicios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '09', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Aportes a los Municipios por transferencia de servicios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '10', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Transferencias y donaciones de Organismos del Sector Público a los ' .
                                  'Consejos Comunales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '10', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Transferencias y donaciones corrientes de Organismos del Sector Público ' .
                                  'a los Consejos Comunales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '10', 'specific' => '01', 'subspecific' => '01',
                'denomination' => 'Transferencias corrientes de Organismos del Sector Público a los Consejos Comunales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '10', 'specific' => '01', 'subspecific' => '02',
                'denomination' => 'Donaciones corrientes de Organismos del Sector Público a los Consejos Comunales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '10', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Transferencias y donaciones de capital de Organismos del Sector Público ' .
                                  'a los Consejos Comunales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '10', 'specific' => '02', 'subspecific' => '01',
                'denomination' => 'Transferencias de capital de Organismos del Sector Público a los Consejos Comunales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '10', 'specific' => '02', 'subspecific' => '02',
                'denomination' => 'Donaciones de capital de Organismos del Sector Público a los Consejos Comunales',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '05', 'generic' => '02', 'specific' => '03', 'subspecific' => '99',
                'denomination' => 'Otras transferencias de capital del sector público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '26', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Asignaciones para atender gastos de los organismos del sector público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '27', 'specific' => '00', 'subspecific' => '00',
                'denomination' => 'Convenio de Cooperación Especial',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '26', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Asignaciones para atender gastos de los organismos del sector público',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '09', 'generic' => '27', 'specific' => '01', 'subspecific' => '00',
                'denomination' => 'Convenio de Cooperación Especial',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '08', 'specific' => '02', 'subspecific' => '03',
                'denomination' => 'Sanciones pecuniarias impuestas a los entes descentralizados con fines ' .
                                  'empresariales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '08', 'generic' => '08', 'specific' => '01', 'subspecific' => '03',
                'denomination' => 'Indemnizaciones por daños y perjuicios ocasionados por entes ' .
                                  'descentralizados con fines empresariales',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '07', 'generic' => '09', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Aportes a los Municipios por transferencia de servicios',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '06', 'specific' => '02', 'subspecific' => '00',
                'denomination' => 'Reparos administrativos al impuesto a las transacciones financieras',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '02', 'generic' => '06', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Multas y recargos por el impuesto a las transacciones financieras',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '06', 'specific' => '03', 'subspecific' => '00',
                'denomination' => 'Impuesto de extracción',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '06', 'specific' => '04', 'subspecific' => '00',
                'denomination' => 'Impuesto de registro de exportación',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '06', 'specific' => '05', 'subspecific' => '00',
                'denomination' => 'Participación por azufre',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '06', 'specific' => '06', 'subspecific' => '00',
                'denomination' => 'Participación por coque',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '04', 'subspecific' => '04',
                'denomination' => 'Impuesto a la operación de juegos de lotería',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '04', 'subspecific' => '05',
                'denomination' => 'Impuesto a las apuestas sobre la explotación de espectáculos hípicos',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '04', 'subspecific' => '06',
                'denomination' => 'Impuesto sobre la organización en general de juegos de envite o azar',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '04', 'subspecific' => '07',
                'denomination' => 'Impuesto sobre apuestas deportivas',
                'active' => true
            ],
            [
                'group' => '3', 'item' => '01', 'generic' => '02', 'specific' => '04', 'subspecific' => '08',
                'denomination' => 'Reparos administrativos impuesto a la operación de juegos de lotería, ' .
                                  'apuestas sobre la explotación de espectáculos hípicos y organización en ' .
                                  'general de juegos de envite o azar y apuestas deportivas',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '51', 'subspecific' => '00',
                'denomination' => 'Capacitación y adiestramiento a parlamentarios',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '01', 'specific' => '36', 'subspecific' => '00',
                'denomination' => 'Sueldo básico del personal de alto nivel y de dirección',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '02', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Compensaciones previstas en las escalas de sueldos del personal de alto ' .
                                  'nivel y de dirección',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '51', 'subspecific' => '00',
                'denomination' => 'Bono compensatorio de alimentación al personal de alto nivel y de dirección',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '16', 'subspecific' => '00',
                'denomination' => 'Aguinaldos al personal de alto nivel y de dirección',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '17', 'subspecific' => '00',
                'denomination' => 'Utilidades legales y convencionales al personal de alto nivel y de dirección',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '39', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al Instituto Venezolano de los Seguros Sociales (IVSS) ' .
                                  'por personal de alto nivel y de dirección',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '41', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al Fondo de Jubilaciones por personal de alto nivel y de dirección',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '06', 'specific' => '42', 'subspecific' => '00',
                'denomination' => 'Aporte patronal al Fondo de Ahorro Habitacional por personal de alto nivel ' .
                                  'y de dirección',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '07', 'specific' => '68', 'subspecific' => '00',
                'denomination' => 'Aporte patronal a cajas de ahorro por personal de alto nivel y de dirección',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '08', 'specific' => '07', 'subspecific' => '00',
                'denomination' => 'Prestaciones sociales e indemnizaciones al personal de alto nivel y de dirección',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '04', 'specific' => '95', 'subspecific' => '00',
                'denomination' => 'Otros complementos al personal de alto nivel y de dirección',
                'active' => true
            ],
            [
                'group' => '4', 'item' => '01', 'generic' => '05', 'specific' => '18', 'subspecific' => '00',
                'denomination' => 'Bono vacacional al personal de alto nivel y de dirección',
                'active' => true
            ]
        ];

        DB::transaction(function () use ($budget_accounts) {
            foreach ($budget_accounts as $account) {
                $parent = BudgetAccount::getParent(
                    $account['group'],
                    $account['item'],
                    $account['generic'],
                    $account['specific'],
                    $account['subspecific']
                );

                BudgetAccount::updateOrCreate(
                    [
                        'group' => $account['group'], 'item' => $account['item'], 'generic' => $account['generic'],
                        'specific' => $account['specific'], 'subspecific' => $account['subspecific']
                    ],
                    [
                        'denomination' => trim($account['denomination']), 'active' => $account['active'],
                        'inactivity_date' => (!$account['active'])?date("Y-m-d"):null,
                        'resource' => ((int)$account['group'] === 3),
                        'egress' => ((int)$account['group'] === 4),
                        'parent_id' => ($parent == false)?null:$parent->id
                    ]
                );
            }
        });
    }
}
