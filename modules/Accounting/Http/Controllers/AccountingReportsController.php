<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;


use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingSeatAccount;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Pdf\Pdf;
use Auth;

class AccountingReportsController extends Controller
{

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.report.accountingbooks', ['only' => ['accountingBooks']]);
        $this->middleware('permission:accounting.report.financestatements', ['only' => ['financeStatements']]);
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function accountingBooks()
    {
        $yearOld =$this->CalcualteYearOld();

        /** @var array arreglo que almacenara la lista de cuentas patrimoniales*/
        $records = [];
        array_push($records, [
                'id' => '0',
                'text' =>  "Seleccione...",
            ]);
        /**
         * se realiza la busqueda de manera ordenada en base al codigo
         */
        foreach (AccountingAccount::orderBy('group', 'ASC')
                                    ->orderBy('subgroup', 'ASC')
                                    ->orderBy('item', 'ASC')
                                    ->orderBy('generic', 'ASC')
                                    ->orderBy('specific', 'ASC')
                                    ->orderBy('subspecific', 'ASC')
                                    ->where('active', true)
                                    ->get() as $account) {
            /** @var array arreglo con datos de las cuentas patrimoniales*/
            array_push($records, [
                'id' => $account->id,
                'text' =>   "{$account->getCode()} - {$account->denomination}",
            ]);
        }
        /**
         * se convierte array a JSON
         */
        $records = json_encode($records);

        return view('accounting::reports.accounting_books', compact('yearOld', 'records'));
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function financeStatements()
    {
        $yearOld =$this->CalcualteYearOld();

        /** @var Object String con el tipo de reporte que abrira */
        $type_report_1 = 'balanceSheet';
        
        /** @var Object String con el tipo de reporte que abrira */
        $type_report_2 = 'stateOfResults';

        return view('accounting::reports.finance_statements', compact('yearOld', 'type_report_1', 'type_report_2'));
    }

    public function CalcualteYearOld()
    {
        /** @var Object Objeto en el que se almacena el registro de asiento contable mas antiguo */
        $seating = AccountingSeat::where('approved', true)->orderBy('from_date', 'ASC')->first();
        
        /** @var Object String con el cual se determinara el año mas antiguo para el filtrado */
        $yearOld = explode('-', $seating['from_date'])[0];

        return $yearOld;
    }
}
