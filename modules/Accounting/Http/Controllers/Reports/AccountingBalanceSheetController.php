<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingEntry;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Models\ExchangeRate;
use App\Repositories\ReportRepository;
use App\Models\Institution;
use Auth;
use DateTime;

/**
 * @class AccountingReportPdfBalanceSheetController
 * @brief Controlador para la generación del reporte de balance general
 *
 * Clase que gestiona el reporte de balance general
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *            LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AccountingBalanceSheetController extends Controller
{

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.report.balancesheet', ['only' => ['pdf','pdfVue']]);
    }

    /**
     * [$convertions lista de conversiones validas]
     * @var array
     */
    protected $convertions = [];

    /**
     * [$currency moneda en la que se expresara el reporte]
     * @var Currency
     */
    protected $currency = null;

    public function getConvertions()
    {
        return $this->convertions;
    }

    public function setConvertions($convertions)
    {
        $this->convertions = $convertions;
    }

    public function getCurrencyId()
    {
        return $this->currency->id;
    }
    
    public function getCurrency()
    {
        return $this->currency;
    }
    /**
     * [setCurrency]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Currency $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }

    /**
     * [pdf genera el reporte en pdf de balance general]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  string   $date     [fecha]
     * @param  string   $level    [nivel de sub cuentas maximo a mostrar]
     * @param  Currency $currency [moneda en que se expresara el reporte]
     * @param  boolean  $zero     [si se tomaran cuentas con saldo cero]
     */
    public function pdfVue($date, $level, Currency $currency, $zero = false)
    {
        /**
         * [$day ultimo dia correspondiente al mes]
         * @var date
         */
        $day = date('d', (mktime(0, 0, 0, explode('-', $date)[1]+1, 1, explode('-', $date)[0])-1));

        /**
         * [$endDate formatea la fecha final de busqueda, (YYYY-mm-dd HH:mm:ss)]
         * @var [type]
         */
        $endDate = $date.'-'.$day;

        /**
         * consulta de cada cuenta y asiento que pertenezca a ACTIVO, PASIVO, PATRIMONIO y CUENTA DE ORDEN
         * [$query registros de las cuentas patrimoniales seleccionadas]
         * @var Modules\Accounting\Models\AccountingAccount
         */
        $query = AccountingAccount::with(['entryAccount.entries' => function ($query) use ($endDate) {
            if ($query->where('from_date', '<=', $endDate)->where('approved', true)) {
                $query->where('from_date', '<=', $endDate)->where('approved', true);
            }
        }])
            ->whereHas('entryAccount.entries', function ($query) use ($endDate) {
                $query->where('from_date', '<=', $endDate)->where('approved', true);
            })
            ->whereBetween('group', [0, 4])
            ->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')
            ->orderBy('denomination', 'ASC')->get();

        $convertions = [];

        /*
         * Se recorre y evalua la relacion en las conversiones necesarias a realizar
         */
        foreach ($query as $record) {
            foreach ($record['entryAccount'] as $entryAccount) {
                $inRange = false;
                if ($entryAccount['entries']) {
                    if (!array_key_exists($entryAccount['entries']['currency']['id'], $convertions)
                        && $entryAccount['entries']['currency']['id'] != $currency->id) {
                        $convertions = $this->calculateExchangeRates(
                            $convertions,
                            $entryAccount['entries'],
                            $currency->id
                        );
                    }
                    
                    foreach ($convertions as $convertion) {
                        foreach ($convertion as $convert) {
                            if ($entryAccount['entries']['from_date'] >= $convert['start_at'] &&
                                $entryAccount['entries']['from_date'] <= $convert['end_at']) {
                                $inRange = true;
                            }
                        }
                    }

                    if (!array_key_exists($entryAccount['entries']['currency']['id'], $convertions)
                            && $entryAccount['entries']['currency']['id'] != $currency->id) {
                        return response()->json([
                            'result'=>false,
                            'message'=>'Imposible expresar '.$entryAccount['entries']['currency']['symbol']
                                        .' ('.$entryAccount['entries']['currency']['name'].')'
                                        .' en '.$currency['symbol'].'('.$currency['name'].')'.
                                        ', verificar tipos de cambio configurados. Para la fecha de '.
                                        $entryAccount['entries']['from_date'],
                        ], 200);
                    } elseif (!$inRange) {
                        if ($entryAccount['entries']['currency']['id'] != $currency->id) {
                            return response()->json([
                                'result'=>false,
                                'message'=>'Imposible expresar '.$entryAccount['entries']['currency']['symbol']
                                            .' ('.$entryAccount['entries']['currency']['name'].')'
                                            .' en '.$currency['symbol'].'('.$currency['name'].')'.
                                            ', verificar tipos de cambio configurados. Para la fecha de '.
                                            $entryAccount['entries']['from_date'],
                            ], 200);
                        }
                    }
                }
            }
        }
        /**
         * [$url link para el reporte]
         * @var string
         */
        $url = 'balanceSheet/pdf/'.$endDate.'/'.$level.'/'.$zero;

        $currentDate = new DateTime;
        $currentDate = $currentDate->format('Y-m-d');

        /**
         * [$report almacena el registro del reporte del dia si existe]
         * @var [type]
         */
        $report = AccountingReportHistory::whereBetween('updated_at', [
                                                                        $currentDate.' 00:00:00',
                                                                        $currentDate.' 23:59:59'
                                                                    ])
                                        ->where('report', 'Balance General')->first();

        /*
        * se crea o actualiza el registro del reporte
        */
        if (!$report) {
            $report = AccountingReportHistory::create(
                [
                    'report' => 'Balance General',
                    'url' => $url,
                    'currency_id' => $currency->id,
                ]
            );
        } else {
            $report->url = $url;
            $report->currency_id = $currency->id;
            $report->save();
        }
        
        return response()->json(['result'=>true, 'id'=>$report->id], 200);
    }

    /**
     * [pdf genera el reporte en pdf de balance general]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  string   $date     [fecha]
     * @param  string   $level    [nivel de sub cuentas maximo a mostrar]
     * @param  Currency $currency [moneda en que se expresara el reporte]
     * @param  boolean  $zero     [si se tomaran cuentas con saldo cero]
     */
    public function pdf($report)
    {
        $report = AccountingReportHistory::with('currency')->find($report);
        $endDate = explode('/', $report->url)[2];
        $level = explode('/', $report->url)[3];
        $zero = explode('/', $report->url)[4];
        $this->setCurrency($report->currency);

        /**
         * [$level_1 consulta de ralación que se desean realizar]
         * @var string
         */
        $level_1 = 'entryAccount.entries';

        /**
         * [$level_2 consulta de ralación que se desean realizar]
         * @var string
         */
        $level_2 = 'children.entryAccount.entries';

        /**
         * [$level_3 consulta de ralación que se desean realizar]
         * @var string
         */
        $level_3 = 'children.children.entryAccount.entries';

        /**
         * [$level_4 consulta de ralación que se desean realizar]
         * @var string
         */
        $level_4 = 'children.children.children.entryAccount.entries';

        /**
         * [$level_5 consulta de ralación que se desean realizar]
         * @var string
         */
        $level_5 = 'children.children.children.children.entryAccount.entries';

        /**
         * [$level_6 consulta de ralación que se desean realizar]
         * @var string
         */
        $level_6 = 'children.children.children.children.children.entryAccount.entries';

        /**
         * Se realiza la consulta de cada cuenta y asiento que pertenezca a ACTIVO, PASIVO, PATRIMONIO y CUENTA DE ORDEN
        */
        $records = AccountingAccount::with($level_1, $level_2, $level_3, $level_4, $level_5, $level_6)
            ->with([$level_1 => function ($query) use ($endDate) {
                $query->where('from_date', '<=', $endDate)->where('approved', true);
            }])
            ->with([$level_2 => function ($query) use ($endDate) {
                $query->where('from_date', '<=', $endDate)->where('approved', true);
            }])
            ->with([$level_3 => function ($query) use ($endDate) {
                $query->where('from_date', '<=', $endDate)->where('approved', true);
            }])
            ->with([$level_4 => function ($query) use ($endDate) {
                $query->where('from_date', '<=', $endDate)->where('approved', true);
            }])
            ->with([$level_5 => function ($query) use ($endDate) {
                $query->where('from_date', '<=', $endDate)->where('approved', true);
            }])
            ->with([$level_6 => function ($query) use ($endDate) {
                $query->where('from_date', '<=', $endDate)->where('approved', true);
            }])
            ->whereBetween('group', [0, 4])
            ->where('subgroup', 0)
            ->orderBy('subgroup', 'ASC')
            ->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')->get();

        /**
         * [$records con los registros de las cuentas]
         * @var array
         */
        $records = $this->formatDataInArray($records);

        /**
         * [$setting configuración general de la apliación]
         * @var [Modules\Accounting\Models\Setting]
         */
        $setting = Setting::all()->first();

        /**
         * [$pdf base para generar el pdf]
         * @var [Modules\Accounting\Pdf\Pdf]
         */
        $pdf = new ReportRepository();

        /*
         *  Definicion de las caracteristicas generales de la página pdf
         */
        $institution = Institution::find(1);
        $pdf->setConfig(['institution' => $institution, 'urlVerify' => url('report/balanceSheet/'.$report->id)]);
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de Balance General');
        $pdf->setFooter();
        $pdf->setBody('accounting::pdf.balance_sheet', true, [
            'pdf' => $pdf,
            'records' => $records,
            'currency' => $this->getCurrency(),
            'level' => $level,
            'zero' => $zero,
            'endDate' => $endDate,
        ]);
    }

    /**
     * [formatDataInArray sintetiza la información de una cuenta en un array con sus respectivas subcuentas]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Modules\Accounting\Models\AccountingAccount $records registro de una cuenta o subcuenta patrimonial
     * @param  int $level [contador que indica el nivel de profundidad de la recursividad
     *                       para obtener subcuentas de una cuenta]
     */
    public function formatDataInArray($records, $level = 1)
    {
        /**
         * [$parent información pertinente de la consultar]
         * @var array
         */
        $parent = [];

        /**
         * [$pos posición de la cuenta base]
         * @var integer
         */
        $pos = 0;

        /**
         * condición de parada del ultimo nivel
         */
        if ($level > 6) {
            return [];
        }

        if (count($records) > 0) {
            foreach ($records as $account) {
                array_push($parent, [
                    'code' => $account->getCodeAttribute(),
                    'denomination' => $account->denomination,
                    'balance' => $this->calculateValuesInEntries($account),
                    'level' => $level,
                    'children' => [],
                    'show_children' => false,
                ]);
                $parent[$pos]['children'] = $this->formatDataInArray($account->children, $level+1);

                /**
                * El atributo 'show_children' se establece que si la cuenta tiene hijos estos se mostraran por omisión
                * aun si no se deseanmostrar cuentas con saldo 0
                */
                $parent[$pos]['show_children'] = (count($parent[$pos]['children']) > 0)?false:true;
                $pos++;
            }
            return $parent;
        }
        return [];
    }

    /**
     * [calculateValuesInEntries realiza el calculo de saldo de la cuenta tomando en cuenta todos sus subcuentas,
     *                           hasta llegar al ultimo nivel de parentela solo se sumaran los valores de los asientos
     *                           contables aprobados]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param [Modules\Accounting\Models\AccountingAccount] $account [registro de una cuenta o subcuenta patrimonial]
     * @return [float] [resultado de realizar la operaciones de suma y resta]
     */
    public function calculateValuesInEntries($account)
    {
        /**
         * [$debit saldo total en el debe de la cuenta]
         * @var float
         */
        $debit = 0.00;

        /**
         * [$assets saldo total en el haber de la cuenta]
         * @var float
         */
        $assets = 0.00;

        /**
         * [$balanceChildren saldo total de la suma de los saldos de sus cuentas hijo]
         * @var float
         */
        $balanceChildren = 0.00;

        foreach ($account->entryAccount as $entryAccount) {
            if ($entryAccount->entries['approved']) {
                if (!array_key_exists($entryAccount['entries']['currency']['id'], $this->getConvertions())) {
                    $this->setConvertions($this->calculateExchangeRates(
                        $this->getConvertions(),
                        $entryAccount['entries'],
                        $this->getCurrencyId()
                    ));
                }

                $debit += ($entryAccount['debit'] != 0)?
                            $this->calculateOperation(
                                $this->getConvertions(),
                                $entryAccount['entries']['currency']['id'],
                                $entryAccount['debit'],
                                $entryAccount['entries']['from_date'],
                                ($entryAccount['entries']['currency']['id'] == $this->getCurrencyId())??false
                            ):0;

                $assets += ($entryAccount['assets'] != 0)?
                            $this->calculateOperation(
                                $this->getConvertions(),
                                $entryAccount['entries']['currency']['id'],
                                $entryAccount['assets'],
                                $entryAccount['entries']['from_date'],
                                ($entryAccount['entries']['currency']['id'] == $this->getCurrencyId())??false
                            ):0;
            }
        }

        if (count($account->children) > 0) {
            foreach ($account->children as $child) {
                /**
                * llamada recursiva y acumulación
                */
                $balanceChildren += $this->calculateValuesInEntries($child);
            }
        }
        
        return (($debit - $assets) + $balanceChildren);
    }

    /**
     * [calculateOperation realiza la conversion de saldo]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  array   $convertions   [lista de tipos cambios para la moneda]
     * @param  integer $entry_id      [identificador del asiento]
     * @param  float   $value         [saldo del asiento]
     * @param  float   $date         [fecha del asiento]
     * @param  boolean $equalCurrency [bandera que indica si el tipo de moneda en el que esta el asiento es las misma
     *                                que la que se desea expresar]
     * @return float                  [resultdado de la operacion]
     */
    public function calculateOperation($convertions, $currency_id, $value, $date, $equalCurrency)
    {
        if ($equalCurrency) {
            return $value;
        }

        if ($currency_id && array_key_exists($currency_id, $convertions) && $convertions[$currency_id]) {
            foreach ($convertions[$currency_id] as $convertion) {
                if ($date >= $convertion['start_at'] && $date <= $convertion['end_at']) {
                    if ($convertion['operator'] == 'to') {
                        return ($value * $convertion['amount']);
                    } else {
                        return ($value / $convertion['amount']);
                    }
                }
            }
        }
        return -1;
    }

    /**
     * [calculateExchangeRates encuentra los tipos de cambio]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  array           $convertions [lista de conversiones]
     * @param  AccountingEntry $entry       [asiento contable]
     * @param  integer         $currency_id [identificador de la moneda a la cual se realizara la conversion]
     * @return array                        [lista de conversiones actualizada]
     */
    public function calculateExchangeRates($convertions, $entry, $currency_id)
    {
        $exchangeRate = ExchangeRate::where('active', true)
                            ->whereIn('to_currency_id', [$entry['currency']['id'], $currency_id])
                            ->whereIn('from_currency_id', [$entry['currency']['id'], $currency_id])
                             ->orderBy('end_at', 'DESC')->get();
        if (count($exchangeRate) != 0) {
            if (!array_key_exists($entry['currency']['id'], $convertions)) {
                $convertions[$entry['currency']['id']] = [];
                foreach ($exchangeRate as $recordExchangeRate) {
                    array_push(
                        $convertions[$entry['currency']['id']],
                        [
                            'amount'   => $recordExchangeRate->amount,
                            'operator' => ($currency_id == $recordExchangeRate->from_currency_id)?'from':'to',
                            'start_at' => $recordExchangeRate->start_at,
                            'end_at'   => $recordExchangeRate->end_at
                        ]
                    );
                }
            }
        }
        return $convertions;
    }

    public function getCheckBreak()
    {
        return $this->PageBreakTrigger;
    }
}
