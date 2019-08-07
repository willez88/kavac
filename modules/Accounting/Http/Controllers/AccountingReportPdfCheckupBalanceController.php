<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingSeatAccount;
use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Pdf\Pdf;
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

class AccountingReportPdfCheckupBalanceController extends Controller
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

    public function build_sorter() {
        return function ($a, $b) {
            return strnatcmp($a->getCode(), $b->getCode());
        };
    }

    /**
     * Consulta y formatea las cuentas en un rango determinado y las almacena en variables en el controlador
     * variable en las que almacena ($accountRecords, $initDate, $endDate)
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $initDate variable con la fecha inicial que recibe formato 'YYYY-mm'
     * @param String $endDate variable con la fecha inicial que recibe formato 'YYYY-mm'
     * @param Boolean $beginningBalance bandera con la que se indica si viene de la funcion CalculateBeginningBalance y limita las operaciones que esta requiere
     */
    public function getAccAccount($initDate, $endDate, $beginningBalance)
    {

        /** @var Object String en el que se formatea la fecha inicial de busqueda */
        $initDate = $initDate.'-01';

        /** @var Object String en que se almacena el ultimo dia correspondiente al mes */
        $endDay = date('d',(mktime(0,0,0,explode('-',$endDate)[1]+1,1,explode('-',$endDate)[0])-1));

        /** @var Object String en el que se formatea la fecha final de busqueda */
        $endDate = $endDate.'-'.$endDay;

        /** @var Object Objeto en el que se almacena la consulta de las cuentas con relación hacia asientos contables en un rango de fecha */
        $RecordArr = AccountingSeatAccount::with('seating', 'account')->whereHas('seating', function($query) use ($initDate, $endDate) {
                                                    $query->whereBetween('from_date',[$initDate,$endDate])->where('approved',true);
                                                })->orderBy('updated_at','ASC')->get();

        /** @var Array array en el que se almacenaran las cuentas patrimoniales de manera unica en el rango dando */
        $records = [];

        /** @var Array array auxiliar para guardar las cuentas ordenadas */
        $arrAux = [];

        /**
        Ciclo los registros de cuentas relacionadas con asiento contables
        */
        foreach ($RecordArr as $accounting_accounts) {
            /** @var boolean bandera que indica si la cuenta ya esta en el array */
            $add = true;
            /**
            Ciclo para verificar que la cuenta no se repita en el array
            */
            for ($i=0; $i < count($records); $i++) { 
                if ($records[$i]->id == $accounting_accounts->account->id) {
                    $add = false;
                    break;
                }
            }

            if (count($records)==0 || $add) {
                array_push($records, $accounting_accounts->account);
            }
        }

        /**
        build_sorter: function compara y ordena las cuentas segun el orden en el código
        */

        usort($records, $this->build_sorter());

        /**
        Se formatean los datos de las cuentas
        */
        $index = 0;
        foreach ($records as $account) {
            $index += 1;
            array_push($arrAux, [
                'id_record' => $account->id,
                'text' => "{$account->getCode()} - {$account->denomination}",
                'id' => $index,
            ]);
        }

        if (!$beginningBalance) {
            $this->setRecords($arrAux);
            $this->setInitDate($initDate);
            $this->setEndDate($endDate);
        }else{
            return $arrAux;
        }
    }

    /**
     * Calcula los saldos iniciales de cada cuenta en el rango dado, y lo alamcena
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $date variable con la fecha inicial que recibe formato 'YYYY-mm'
     */
    public function CalculateBeginningBalance($date)
    {
        /** @var Object Objeto en el que se almacena el registro de asiento contable mas antiguo */
        $seating = AccountingSeat::where('approved', true)->orderBy('from_date','ASC')->first();
       
        /**
         Se establecen las fechas validas anteriores a la fecha suministrada para realizar la busqueda de registros
        */

        /** @var Object String con el cual se determinara el año mas antiguo para el filtrado */
        $initDate = explode('-',$seating['from_date'])[0].'-'.explode('-',$seating['from_date'])[1];

        /** @var Object String en que se almacena el ultimo dia correspondiente al mes */
        $endDay = date('d',(mktime(0,0,0,explode('-',$date)[1]+1,1,explode('-',$date)[0])-1));

        /** @var Object String en el que establece el mes anterior */
        $endMonth = (((int)explode('-',$date)[1])-1 == 0) ? 12 : (((int)explode('-',$date)[1])-1);

        /** @var Object String en el que se establece el año anterior de ser necesario */
        $endYear = (((int)explode('-',$date)[1])-1 == 0) ? (((int)explode('-',$date)[0])-1) : (((int)explode('-',$date)[0]));

        /** @var Object String en el que se formatea la fecha final de busqueda */
        $endDate = $endYear.'-'.$endMonth;

        $accounts = $this->getAccAccount($initDate, $endDate, true);

        /**
        Ciclo en el que se calcula y almancena los saldos iniciales de cada cuenta
        */
        foreach ($accounts as $account) {
            $balance = 0;
            foreach (AccountingSeatAccount::with('seating','account')
                        ->where('accounting_account_id', $account['id_record'])
                        ->whereHas('seating', function($query) use ($initDate, $endDate, $endDay) {
                            $query->whereBetween('from_date',[$initDate.'-01',($endDate.'-'.$endDay)])->where('approved',true);
                        })->orderBy('updated_at','ASC')->get() as $record) {
                $balance += (float)$record->debit - (float)$record->assets;
            }
            $this->setBeginningBalance($account['id_record'], $balance);
        }
    }

    /**
     * vista en la que se genera el reporte en pdf de balance de comprobación
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $initDate variable con la fecha inicial
     * @param String $endDate variable con la fecha inicial
     */
    public function pdf($initDate, $endDate)
    {

        /**
        * Se guarda un registro cada vez que se genera un reporte, en caso de que ya exista se actualiza
        */
        $url = 'BalanceCheckUp/pdf/'.$initDate.'/'.$endDate;
        
        AccountingReportHistory::updateOrCreate([
                                                    'name' => 'Balance de Comporbación',
                                                    'report' => 1 
                                                ],
                                                [
                                                    'url' => $url,
                                                ]);

        $this->getAccAccount($initDate, $endDate, false);

        /** Cálcula el saldo inicial que tendra la cuenta*/
        $this->CalculateBeginningBalance($initDate);

        /** @var Array Arreglo asociativo con la información base (id, id_record y denomination) de las cuentas patrimoniales */
        $accountRecords = $this->getRecords();

        /** @var Array Arreglo asociativo con la información del saldo inicial (id => balance) de las cuentas patrimoniales */
        $beginningBalance = $this->getBeginningBalance();

        /** @var Int indice de la cuenta desde donde finalizara la busqueda */
        $EndIndex = count($accountRecords)-1;

        /** @var Object Objeto con los registros de las cuentas patrimoniales seleccionadas */
        $records = [];

        /** @var Object Cadena de Texto con la fecha inicial del rango */
        $initDate = $this->getInitDate();

        /** @var Object Cadena de Texto con la fecha final del rango */
        $endDate = $this->getEndDate();

        for ($i = 0 ; $i <= $EndIndex; $i++) {
            $id_record = $accountRecords[$i]['id_record'];

            // realiza la consulta de las cuentas usadas en asientos contables en el rango dado
            array_push($records, AccountingSeatAccount::with('seating','account')
                                                ->where('accounting_account_id', $id_record)
                                                ->whereHas('seating', function($query) use ($initDate, $endDate) {
                                                    $query->whereBetween('from_date',[$initDate,$endDate])->where('approved',true);
                                                })->orderBy('updated_at','ASC')->get()
            );
        }

        /** @var Object configuración general de la apliación */
        $setting = Setting::all()->first();

        /** @var Object con la información de la modena por defecto establecida en la aplicación */
        $currency = Currency::where('default',true)->first();

        /** @var Object Objeto base para generar el pdf */
        $pdf = new Pdf('L','mm','Letter');
        
        /*
         *  Definicion de las caracteristicas generales de la página
         */

        if (isset($setting) and $setting->report_banner == true)
            $pdf->SetMargins(10, 65, 10);
        else
            $pdf->SetMargins(10, 55, 10);
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_FOOTER);

        $pdf->setType('Balance de Comprobación');
        $pdf->Open();
        $pdf->AddPage();

        $html = \View::make('accounting::pdf.accounting_checkup_balance_pdf',compact('pdf','records','initDate','endDate','currency','beginningBalance'))->render();
        $pdf->SetFont('Courier','B',8);

        $pdf->writeHTML($html, true, false, true, false, '');

        $pdf->Output("Balance_de_Comprobación_{$initDate}_{$endDate}.pdf");
    }

    public function get_checkBreak(){
        return $this->PageBreakTrigger;
    }

}
