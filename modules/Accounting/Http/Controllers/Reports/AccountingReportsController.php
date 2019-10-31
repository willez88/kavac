<?php

namespace Modules\Accounting\Http\Controllers\Reports;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingEntryAccount;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingEntry;
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
        $yearOld = $this->calcualteYearOld();

        /** @var array arreglo que almacenara la lista de cuentas patrimoniales*/
        $records = [];
        $records_auxiliar = [];
        array_push($records, [
                'id' => '0',
                'text' =>  "Seleccione...",
            ]);
        array_push($records_auxiliar, [
                'id' => '0',
                'text' =>  "Seleccione...",
            ]);
        array_push($records_auxiliar, [
                'id' => '',
                'text' =>  "Todas",
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
                'text' =>   "{$account->getCodeAttribute()} - {$account->denomination}",
            ]);
            if ($account->group > 0 && $account->subgroup > 0 && $account->item > 0) {
                array_push($records_auxiliar, [
                    'id' => $account->id,
                    'text' =>   "{$account->getCodeAttribute()} - {$account->denomination}",
                ]);
            }
        }
        /**
         * se convierte array a JSON
         */
        $records_auxiliar = json_encode($records_auxiliar);
        $records = json_encode($records);
        $currencies = json_encode(template_choices('App\Models\Currency', ['symbol', '-', 'name'], [], true));
        
        return view('accounting::reports.accounting_books', compact(
            'yearOld',
            'records',
            'records_auxiliar',
            'currencies'
        ));
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function financeStatements()
    {
        $yearOld = $this->calcualteYearOld();

        /** @var Object String con el tipo de reporte que abrira */
        $type_report_1 = 'BalanceSheet';
        
        /** @var Object String con el tipo de reporte que abrira */
        $type_report_2 = 'StateOfResults';

        $currencies = json_encode(template_choices('App\Models\Currency', ['symbol', '-', 'name'], [], true));

        return view('accounting::reports.finance_statements', compact(
            'yearOld',
            'type_report_1',
            'type_report_2',
            'currencies'
        ));
    }

    public function calcualteYearOld()
    {
        /** @var Object Objeto en el que se almacena el registro de asiento contable mas antiguo */
        $entries = AccountingEntry::where('approved', true)->orderBy('from_date', 'ASC')->first();
        
        /** @var Object String con el cual se determinara el año mas antiguo para el filtrado */
        $yearOld = explode('-', $entries['from_date'])[0];

        return $yearOld;
    }
}
