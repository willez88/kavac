<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingSeatAccount;
use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use App\Repositories\ReportRepository;
use App\Models\Institution;
use Auth;

/**
 * @class AccountingReportPdfCheckupBalanceController
 * @brief Controlador para la generación del reporte de Balance de Comprobación
 *
 * Clase que gestiona el reporte de balance de comprobación
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
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
        $this->middleware('permission:accounting.report.checkupbalance', ['only' => ['getAccAccount', 'CalculateBeginningBalance', 'pdf']]);
    }

    /** @var Array array en el que se almacenara la información del saldo inicial de cuentas patrimoniales */
    protected $beginningBalance = null;
    /** @var Array array en el que se almacenara la información de cuentas patrimoniales */
    protected $accountRecords;
    /** @var String cadena en la que se almacenara la fecha del rango inicial de busqueda */
    protected $initDate;
    /** @var String cadena en la que se almacenara la fecha del rango final de busqueda */
    protected $endDate;

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

    public function build_sorter()
    {
        return function ($a, $b) {
            return strnatcmp($a->getCodeAttribute(), $b->getCodeAttribute());
        };
    }

    /**
     * [calculateSum calcula la suma de los saldos de la cuenta en los asientos consatbles aprobados]
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Integer $beginningBalance [saldo inicial en caso de tener]
     * @param  Array $seatAccounts     [arreglo de tipo Modules\Accounting\Models\AccountingSeatAccount]
     * @return Float    [suma total]
     */
    public function calculateSum($beginningBalance, $seatAccounts)
    {
        $res = 0;
        foreach ($seatAccounts as $seatAccount) {
            if ($seatAccount['seating']) {
                $res += (floatval($seatAccount['debit']) - floatval($seatAccount['assets']));
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
     * @param Boolean $returnArray bandera con la que se indica si viene de la funcion CalculateBeginningBalance
     *                                      y limita las operaciones que esta requiere
     * @param Array $beginningBalance lista con los saldos uniciales de las cuentas que sean distintos de 0
     * @param Boolean $allRecords Bandera que indica si se consultaran las cuentas con 0 operaciones
     */
    public function getAccAccount($initDate, $endDate, $returnArray, $beginningBalance = [], $all)
    {
        $beginningBalance = (!$beginningBalance)?[]:$beginningBalance;

        /**
         * [$query almacenara la consulta]
         * @var array
         */
        $query = [];

        /** @var Object String en el que se formatea la fecha inicial de busqueda */
        $initDate = $initDate.'-01';

        /** @var Object String en que se almacena el ultimo dia correspondiente al mes */
        $endDay = date('d', (mktime(0, 0, 0, explode('-', $endDate)[1]+1, 1, explode('-', $endDate)[0])-1));

        /** @var Object String en el que se formatea la fecha final de busqueda */
        $endDate = $endDate.'-'.$endDay;

        /** @var Array array en el que se almacenaran las cuentas patrimoniales de manera unica en el rango dando */
        $records = [];

        /** @var Array array auxiliar para guardar las cuentas ordenadas */
        $arrAux = [];

        /**
        * Ciclo los registros de cuentas relacionadas con asiento contables
        */
        if ($all) {
            $query = AccountingAccount::with(['seatAccount.seating' => function ($query) use ($initDate, $endDate) {
                if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                    $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                }
            }])
            ->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')
            ->orderBy('denomination', 'ASC')->get();
        } else {
            $query = AccountingAccount::with(['seatAccount.seating' => function ($query) use ($initDate, $endDate) {
                if ($query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true)) {
                    $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                }
            }])
            ->whereHas('seatAccount.seating', function ($query) use ($initDate, $endDate) {
                $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
            })
            ->orderBy('group', 'ASC')
            ->orderBy('subgroup', 'ASC')
            ->orderBy('item', 'ASC')
            ->orderBy('generic', 'ASC')
            ->orderBy('specific', 'ASC')
            ->orderBy('subspecific', 'ASC')
            ->orderBy('denomination', 'ASC')->get();
        }
        foreach ($query as $account) {
            /** @var boolean bandera que indica si la cuenta ya esta en el array */
            $add = true;
            /**
            Ciclo para verificar que la cuenta no se repita en el array
            */
            for ($i=0; $i < count($records); $i++) {
                if ($records[$i]->id == $account->id) {
                    $add = false;
                    break;
                }
            }

            if (count($records)==0 || $add) {
                array_push($records, $account);
            }
        }
        /**
        build_sorter: function compara y ordena las cuentas segun el orden en el código
        */

        usort($records, $this->build_sorter());
        // dd($records);
        /**
        Se formatean los datos de las cuentas
        */
        $index = 0;
        foreach ($records as $account) {
            $index += 1;
            if (!$returnArray) {
                $val = $this->calculateSum(
                    (array_key_exists($account->id, $beginningBalance)? $beginningBalance[$account->id]:0),
                    $account->seatAccount
                );

                $beg = (array_key_exists($account->id, $beginningBalance)
                                             ? $beginningBalance[$account->id]:0);
                array_push($arrAux, [
                    // 'id_record' => $account->id,
                    'code' => $account->getCodeAttribute(),
                    'denomination' => $account->denomination,
                    // 'id' => $account->id,
                    // 'seats' => $account->seatAccount,
                    'beginningBalance' => $beg,
                    'sum_debit' => ($val >= 0) ? $val : null,
                    'sum_assets' => ($val < 0) ? $val : null,
                    'balance_debit' => (floatval($beg)+$val >= 0) ? floatval($beg)+$val : null ,
                    'balance_assets' => (floatval($beg)+$val < 0) ? floatval($beg)+$val : null ,
                ]);
            } else {
                array_push($arrAux, [
                    'id' => $account->id,
                ]);
            }
        }

        if (!$returnArray) {
            $this->setRecords($arrAux);
            $this->setInitDate($initDate);
            $this->setEndDate($endDate);
        }
        return $arrAux;
    }

    /**
     * Calcula los saldos iniciales de cada cuenta en el rango dado, y lo alamcena
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $date variable con la fecha inicial que recibe formato 'YYYY-mm'
     */
    public function CalculateBeginningBalance($date, $all)
    {
        /** @var Object Objeto en el que se almacena el registro de asiento contable mas antiguo */
        $seating = AccountingSeat::where('approved', true)->orderBy('from_date', 'ASC')->first();
       
        /**
         Se establecen las fechas validas anteriores a la fecha suministrada para realizar la busqueda de registros
        */

        /** @var Object String con el cual se determinara el año mas antiguo para el filtrado */
        $initDate = explode('-', $seating['from_date'])[0].'-'.explode('-', $seating['from_date'])[1];

        /** @var Object String en que se almacena el ultimo dia correspondiente al mes */
        $endDay = date('d', (mktime(0, 0, 0, explode('-', $date)[1], 1, explode('-', $date)[0])-1));

        /** @var Object String en el que se establece el año anterior de ser necesario */
        $endYear = (((int)explode('-', $date)[0])-1 == 0 || ((int)explode('-', $date)[1])-1 == 0) ? (((int)explode('-', $date)[0])-1)
                                                          : (((int)explode('-', $date)[0]));
        /** @var Object String en el que establece el mes anterior */
        $endMonth = (((int)explode('-', $date)[1])-1 == 0) ? 12 : (((int)explode('-', $date)[1])-1);


        /** @var Object String en el que se formatea la fecha final de busqueda */
        $endDate = $endYear.'-'.$endMonth;
        $accounts = $this->getAccAccount($initDate, $endDate, true, null, $all);
        // dd($accounts);
        /**
        * Ciclo en el que se calcula y almancena los saldos iniciales de cada cuenta
        */
        foreach ($accounts as $account) {
            $balance = 0;
            foreach (AccountingSeatAccount::with('seating', 'account')
                        ->where('accounting_account_id', $account['id'])
                        ->whereHas('seating', function ($query) use ($initDate, $endDate, $endDay) {
                            $query->whereBetween('from_date', [$initDate.'-01',($endDate.'-'.$endDay)])
                            ->where('approved', true);
                        })->orderBy('updated_at', 'ASC')->get() as $record) {
                $balance += (float)$record->debit - (float)$record->assets;
            }
            if ($balance!=0) {
                $this->setBeginningBalance($account['id'], $balance);
            }
        }
    }

    /**
     * vista en la que se genera el reporte en pdf de balance de comprobación
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $initDate variable con la fecha inicial
     * @param String $endDate variable con la fecha inicial
     */
    public function pdf($initDate, $endDate, $all = false)
    {
        if ($all != false) {
            $all = true;
        }

        /**
        * Se guarda un registro cada vez que se genera un reporte, en caso de que ya exista se actualiza
        */
        $url = 'BalanceCheckUp/pdf/'.$initDate.'/'.$endDate;
        $url = $url.'/'.(($all)?'all':'');
        
        AccountingReportHistory::updateOrCreate(
            [
                'url' => $url,
            ],
            [
                'report' => 'Balance de Comporbación'.(($all)?' - todas las cuentas':' - solo cuentas con operaciones'),
            ]
        );

        /** Cálcula el saldo inicial que tendra la cuenta*/
        $this->CalculateBeginningBalance($initDate, $all);

        /** @var Array Arreglo asociativo con la información del saldo inicial (id => balance) de las cuentas patrimoniales */
        $beginningBalance = $this->getBeginningBalance();

        

        /** @var Array Arreglo asociativo con la información base (id, id_record y denomination) de las cuentas patrimoniales */
        $accountRecords = $this->getAccAccount($initDate, $endDate, false, $beginningBalance, $all);
        // dd($accountRecords);

        /** @var Object Cadena de Texto con la fecha inicial del rango */
        $initDate = $this->getInitDate();

        /** @var Object Cadena de Texto con la fecha final del rango */
        $endDate = $this->getEndDate();

        // dd($accountRecords);

        /** @var Object configuración general de la apliación */
        $setting = Setting::all()->first();

        /** @var Object con la información de la modena por defecto establecida en la aplicación */
        $currency = Currency::where('default', true)->first();

        /**
         * [$pdf base para generar el pdf]
         * @var [Modules\Accounting\Pdf\Pdf]
         */
        $pdf = new ReportRepository();

        /*
         *  Definicion de las caracteristicas generales de la página pdf
         */
        $institution = Institution::find(1);
        $pdf->setConfig(['institution' => $institution, 'urlVerify' => 'www.google.com']);
        $pdf->setHeader('Reporte de Contabilidad', 'Reporte de Balance de Comprobación');
        $pdf->setFooter();
        $pdf->setBody('accounting::pdf.checkup_balance', true, [
            'pdf' => $pdf,
            'records' => $accountRecords,
            'initDate' => $initDate,
            'endDate' => $endDate,
            'currency' => $currency,
            'beginningBalance' => $beginningBalance,
        ]);
    }

    public function get_checkBreak()
    {
        return $this->PageBreakTrigger;
    }
}
