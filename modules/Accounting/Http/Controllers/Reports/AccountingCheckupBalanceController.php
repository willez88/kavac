<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingEntryAccount;
use Modules\Accounting\Models\AccountingEntry;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Models\ExchangeRate;
use Modules\Accounting\Models\Institution;
use Modules\Accounting\Models\Profile;

use App\Repositories\ReportRepository;
use DateTime;
use Auth;

/**
 * @class AccountingReportPdfCheckupBalanceController
 * @brief Controlador para la generación del reporte de Balance de Comprobación
 *
 * Clase que gestiona el reporte de balance de comprobación
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingCheckupBalanceController extends Controller
{

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.report.checkupbalance', [
            'only' => ['getAccAccount', 'calculateBeginningBalance', 'pdf','pdfVue']
        ]);
    }

    /**
     * [$beginningBalance información del saldo inicial de cuentas patrimoniales]
     * @var null
     */
    protected $beginningBalance = null;

    /**
     * [$accountRecords información de cuentas patrimoniales]
     * @var array
     */
    protected $accountRecords;
    /**
     * [$initDate fecha del rango inicial de busqueda]
     * @var string
     */
    protected $initDate;

    /**
     * [$endDate fecha del rango final de busqueda]
     * @var string
     */
    protected $endDate;

    /**
     * [$convertions lista de conversiones validas]
     * @var array
     */
    protected $convertions = [];

    /**
     * [$currency moneda en la que se expresara el reporte]
     * @var Currency
     */
    protected $currency;

    public function setRecords($records)
    {
        $this->accountRecords = $records;
    }

    public function getRecords()
    {
        return $this->accountRecords;
    }

    public function setBeginningBalanceRecord($index, $balance)
    {
        return $this->accountRecords[$index]['beginningBalance'] = $balance;
    }

    public function setBeginningBalance($key, $value)
    {
        if (is_null($this->beginningBalance)) {
            $this->beginningBalance = [];
        }
        $this->beginningBalance[$key] = $value;
    }

    public function getBeginningBalance()
    {
        return $this->beginningBalance;
    }

    public function setInitDate($date)
    {
        $this->initDate = $date;
    }

    public function getInitDate()
    {
        return $this->initDate;
    }

    public function setEndDate($date)
    {
        $this->endDate = $date;
    }

    public function getEndDate()
    {
        return $this->endDate;
    }

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
        return $this->currency['id'];
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
     * [calculateSum calcula la suma de los saldos de la cuenta en los asientos consatbles aprobados]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Integer $beginningBalance [saldo inicial en caso de tener]
     * @param  Array $entryAccounts     [arreglo de tipo Modules\Accounting\Models\AccountingEntry4Account]
     * @return Float    [suma total]
     */
    public function calculateSum($beginningBalance, $entryAccounts)
    {
        $res = 0;
        foreach ($entryAccounts as $entryAccount) {
            if ($entryAccount['entries']) {
                if (!array_key_exists($this->getCurrencyId(), $this->getConvertions())) {
                    $this->setConvertions($this->calculateExchangeRates(
                        $this->getConvertions(),
                        $entryAccount['entries'],
                        $this->getCurrencyId()
                    ));
                }
                $res += $this->calculateOperation(
                    $this->getConvertions(),
                    $entryAccount['entries']['currency']['id'],
                    (floatval($entryAccount['debit']) - floatval($entryAccount['assets'])),
                    $entryAccount['entries']['from_date'],
                    ($entryAccount['entries']['currency']['id'] == $this->getCurrencyId())??false
                );
            }
        }

        return $res;
    }

    /**
     * Consulta y formatea las cuentas en un rango determinado y las almacena en variables en el controlador
     * variable en las que almacena ($accountRecords, $initDate, $endDate)
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $initDate variable con la fecha inicial que recibe formato 'YYYY-mm'
     * @param String $endDate variable con la fecha inicial que recibe formato 'YYYY-mm'
     * @param Boolean $returnArray bandera con la que se indica si viene de la funcion calculateBeginningBalance
     *                                      y limita las operaciones que esta requiere
     * @param Array $beginningBalance lista con los saldos uniciales de las cuentas que sean distintos de 0
     * @param Boolean $allRecords Bandera que indica si se consultaran las cuentas con 0 operaciones
     */
    public function getAccAccount($initDate, $endDate, $returnArray, $all, $beginningBalance = [])
    {
        $beginningBalance = (!$beginningBalance)?[]:$beginningBalance;

        /**
         * [$query almacenara la consulta]
         * @var array
         */
        $query = [];

        /**
         * [$records almacenaran las cuentas patrimoniales de manera unica en el rango dando]
         * @var array
         */
        $records = [];

        /**
         * [$arrAux auxiliar para guardar las cuentas ordenadas]
         * @var array
         */
        $arrAux = [];

        $institution_id = null;

        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        if ($user_profile['institution']) {
            $institution_id = $user_profile['institution']['id'];
        }

        $is_admin = auth()->user()->isAdmin();
        if ($all) {
            $query = AccountingAccount::with([
                'entryAccount.entries' => function ($query) use ($initDate, $endDate, $institution_id, $is_admin) {
                    if ($institution_id) {
                        if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                                ->where('institution_id', $institution_id)) {
                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                                ->where('institution_id', $institution_id);
                        }
                    } else {
                        if ($is_admin) {
                            if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                                $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                            }
                        }
                    }
                }]);
        } else {
            $query = AccountingAccount::with([
                'entryAccount.entries' => function ($query) use ($initDate, $endDate, $institution_id, $is_admin) {
                    if ($institution_id) {
                        if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                                ->where('institution_id', $institution_id)) {
                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                                ->where('institution_id', $institution_id);
                        }
                    } elseif ($is_admin) {
                        if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                        }
                    }
                }])
                ->whereHas(
                    'entryAccount.entries',
                    function ($query) use ($initDate, $endDate, $institution_id, $is_admin) {
                        if ($institution_id) {
                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                                ->where('institution_id', $institution_id);
                        } elseif ($is_admin) {
                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                        }
                    }
                );
        }
        $query = $query->orderBy('group', 'ASC')
                        ->orderBy('subgroup', 'ASC')
                        ->orderBy('item', 'ASC')
                        ->orderBy('generic', 'ASC')
                        ->orderBy('specific', 'ASC')
                        ->orderBy('subspecific', 'ASC')
                        ->orderBy('denomination', 'ASC')->get();
        /**
        * Ciclo los registros de cuentas relacionadas con asiento contables
        */
        foreach ($query as $account) {
            /**
             * [$add indica si la cuenta ya esta en el array]
             * @var boolean
             */
            $add = true;

            /**
             * [$lengthRecords tamaño del arreglo]
             * @var [type]
             */
            $lengthRecords = count($records);

            /**
            * Ciclo para verificar que la cuenta no se repita en el array
            */
            for ($i=0; $i < $lengthRecords; $i++) {
                if ($records[$i]['id'] == $account->id) {
                    $add = false;
                    break;
                }
            }

            if ($lengthRecords==0 || $add) {
                if (!$returnArray) {
                    $val = $this->calculateSum(
                        (array_key_exists($account->id, $beginningBalance)? $beginningBalance[$account->id]:0),
                        $account->entryAccount
                    );

                    $beg = (array_key_exists($account->id, $beginningBalance)
                                                 ? $beginningBalance[$account->id]:0);
                    array_push($records, [
                        'id'               => $account->id,
                        'code'             => $account->getCodeAttribute(),
                        'denomination'     => $account->denomination,
                        'beginningBalance' => $beg,
                        'sum_debit'        => ($val >= 0) ? $val : null,
                        'sum_assets'       => ($val < 0) ? $val : null,
                        'balance_debit'    => (floatval($beg)+$val >= 0) ? floatval($beg)+$val : null ,
                        'balance_assets'   => (floatval($beg)+$val < 0) ? floatval($beg)+$val : null ,
                    ]);
                } else {
                    array_push($records, [
                        'id' => $account->id,
                    ]);
                }
            }
        }

        if (!$returnArray) {
            $this->setRecords($records);
            $this->setInitDate($initDate);
            $this->setEndDate($endDate);
        }
        return $records;
    }

    /**
     * Calcula los saldos iniciales de cada cuenta en el rango dado, y lo alamcena
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $date variable con la fecha inicial que recibe formato 'YYYY-mm'
     */
    public function calculateBeginningBalance($initDate, $endDate, $all)
    {
        /**
         * [$entries almacena el registro de asiento contable mas antiguo]
         * @var AccountingEntry
         */
        $entries = AccountingEntry::where('approved', true)->orderBy('from_date', 'ASC')->first();

        $accounts = $this->getAccAccount($initDate, $endDate, true, $all, null);

        $institution_id = null;

        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        if ($user_profile['institution']) {
            $institution_id = $user_profile['institution']['id'];
        }

        $is_admin = auth()->user()->isAdmin();

        /**
        * Ciclo en el que se calcula y almancena los saldos iniciales de cada cuenta
        */
        foreach ($accounts as $account) {
            $balance = 0;
            foreach (AccountingEntryAccount::with('entries', 'account')
                        ->where('accounting_account_id', $account['id'])
                        ->whereHas('entries', function ($query) use ($initDate, $institution_id, $is_admin) {
                            if ($institution_id) {
                                $query->where('from_date', '<', $initDate)->where('approved', true)
                                    ->where('institution_id', $institution_id);
                            } else {
                                if ($is_admin) {
                                    $query->where('from_date', '<', $initDate)->where('approved', true);
                                }
                            }
                        })->orderBy('updated_at', 'ASC')->get() as $record) {
                $balance += (float)$record->debit - (float)$record->assets;
            }
            if ($balance!=0) {
                $this->setBeginningBalance($account['id'], $balance);
            }
        }
    }

    public function pdfVue($initDate, $endDate, Currency $currency, $all = false)
    {
        if ($all != false) {
            $all = true;
        }

        /**
         * [$initDate fecha inicial de busqueda]
         * @var string
         */
        $initDate = $initDate.'-01';

        /**
         * [$endDay ultimo dia correspondiente al mes]
         * @var string
         */
        $endDay = date('d', (mktime(0, 0, 0, explode('-', $endDate)[1]+1, 1, explode('-', $endDate)[0])-1));

        /**
         * [$endDate fecha final de busqueda]
         * @var string
         */
        $endDate = $endDate.'-'.$endDay;

        /**
         * [$query almacenara la consulta]
         * @var array
         */
        $query = [];

        /**
        * Ciclo los registros de cuentas relacionadas con asiento contables
        */
        $institution_id = null;

        $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();

        if ($user_profile['institution']) {
            $institution_id = $user_profile['institution']['id'];
        }

        $is_admin = auth()->user()->isAdmin();
        if ($all) {
            $query = AccountingAccount::with([
                'entryAccount.entries' => function ($query) use ($initDate, $endDate, $institution_id, $is_admin) {
                    if ($institution_id) {
                        if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                                ->where('institution_id', $institution_id)) {
                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                                ->where('institution_id', $institution_id);
                        }
                    } else {
                        if ($is_admin) {
                            if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                                $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                            }
                        }
                    }
                }]);
        } else {
            $query = AccountingAccount::with([
                'entryAccount.entries' => function ($query) use ($initDate, $endDate, $institution_id, $is_admin) {
                    if ($institution_id) {
                        if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                                ->where('institution_id', $institution_id)) {
                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                                ->where('institution_id', $institution_id);
                        }
                    } elseif ($is_admin) {
                        if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                        }
                    }
                }])
                ->whereHas(
                    'entryAccount.entries',
                    function ($query) use ($initDate, $endDate, $institution_id, $is_admin) {
                        if ($institution_id) {
                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)
                                ->where('institution_id', $institution_id);
                        } elseif ($is_admin) {
                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                        }
                    }
                );
        }
        $query = $query->orderBy('group', 'ASC')
                        ->orderBy('subgroup', 'ASC')
                        ->orderBy('item', 'ASC')
                        ->orderBy('generic', 'ASC')
                        ->orderBy('specific', 'ASC')
                        ->orderBy('subspecific', 'ASC')
                        ->orderBy('denomination', 'ASC')->get();
        /*
         * Se recorre y evalua la relacion en las conversiones necesarias a realizar
         */
        foreach ($query as $record) {
            foreach ($record['entryAccount'] as $entryAccount) {
                $inRange = false;
                if ($entryAccount['entries']) {
                    if (!array_key_exists($entryAccount['entries']['currency']['id'], $this->getConvertions())
                        && $entryAccount['entries']['currency']['id'] != $currency->id) {
                        $this->setConvertions($this->calculateExchangeRates(
                            $this->getConvertions(),
                            $entryAccount['entries'],
                            $currency['id']
                        ));
                    }

                    foreach ($this->getConvertions() as $convertion) {
                        foreach ($convertion as $convert) {
                            if ($entryAccount['entries']['from_date'] >= $convert['start_at'] &&
                                $entryAccount['entries']['from_date'] <= $convert['end_at']) {
                                $inRange = true;
                            }
                        }
                    }

                    if (!array_key_exists($entryAccount['entries']['currency']['id'], $this->getConvertions())
                        && $entryAccount['entries']['currency']['id'] != $currency['id']) {
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
        * Se guarda un registro cada vez que se genera un reporte, en caso de que ya exista se actualiza
        */
        $all         = ($all != false)?'true':'';

        $url         = 'balanceCheckUp/'.$initDate.'/'.$endDate.'/'.$all;

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
                                        ->where('report', 'Balance de Comporbación'.(($all)?' - todas las cuentas':
                                                                ' - solo cuentas con operaciones'))
                                        ->where('institution_id', $institution_id)->first();

        /*
        * se crea o actualiza el registro del reporte
        */
        if (!$report) {
            $report = AccountingReportHistory::create(
                [
                    'url'            => $url,
                    'currency_id'    => $currency['id'],
                    'institution_id' => $institution_id,
                    'report'         => 'Balance de Comporbación'.(($all)?' - todas las cuentas' :
                                                                          ' - solo cuentas con operaciones'),
                ]
            );
        } else {
            $report->url            = $url;
            $report->currency_id    = $currency['id'];
            $report->institution_id = $institution_id;
            $report->save();
        }

        return response()->json(['result'=>true, 'id'=>$report->id], 200);
    }

    /**
     * [pdf vista en la que se genera el reporte en pdf de balance de comprobación]
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  integer $report [id de reporte y su informacion]
     */
    public function pdf($report)
    {
        $report = AccountingReportHistory::with('currency')->find($report);
        // Validar acceso para el registro
        if (!auth()->user()->isAdmin()) {
            $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();
            if ($report && $report->queryAccess($user_profile['institution']['id'])) {
                return view('errors.403');
            }
        }
        $this->setInitDate(explode('/', $report->url)[1]);
        $this->setEndDate(explode('/', $report->url)[2]);
        $all = explode('/', $report->url)[3];
        $this->setCurrency($report->currency);

        /**
         * [$initDate fecha inicial del rango]
         * @var String
         */
        $initDate = $this->getInitDate();

        /**
         * [$endDate fecha final del rango]
         * @var String
         */
        $endDate = $this->getEndDate();

        /** Cálcula el saldo inicial que tendra la cuenta*/
        $this->calculateBeginningBalance($initDate, $endDate, $all);

        /**
         * [$beginningBalance información del saldo inicial (id => balance) de las cuentas patrimoniales]
         * @var array
         */
        $beginningBalance = $this->getBeginningBalance();

        /**
         * [$accountRecords asociativo con la información base]
         * @var array
         */
        $accountRecords = $this->getAccAccount($initDate, $endDate, false, $all, $beginningBalance);

        $initDate       = new DateTime($initDate);
        $endDate        = new DateTime($endDate);

        $initDate       = $initDate->format('d/m/Y');
        $endDate        = $endDate->format('d/m/Y');

        /**
         * [$setting configuración general de la apliación]
         * @var Modules\Accounting\Models\Setting
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
        $pdf->setConfig(['institution' => $institution, 'urlVerify' => url('report/balanceCheckUp/'.$report->id)]);
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de Balance de Comprobación');
        $pdf->setFooter();
        $pdf->setBody('accounting::pdf.checkup_balance', true, [
            'pdf'              => $pdf,
            'records'          => $accountRecords,
            'initDate'         => $initDate,
            'endDate'          => $endDate,
            'currency'         => $this->getCurrency(),
            'beginningBalance' => $beginningBalance,
        ]);
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
