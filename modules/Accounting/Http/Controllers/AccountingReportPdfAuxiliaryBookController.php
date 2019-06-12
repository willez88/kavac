<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Accounting\Models\AccountingSeatAccount;
use Modules\Accounting\Models\AccountingAccount;
use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\Institution;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Pdf\Pdf;
use Auth;

class AccountingReportPdfAuxiliaryBookController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        /** @var Object Objeto en el que se almacena el registro de asiento contable mas antiguo */
        $seating = AccountingSeat::where('approved', true)->orderBy('from_date','ASC')->first();
        
        /** @var Object String con el cual se determinara el año mas antiguo para el filtrado */
        $year_old = explode('-',$seating['from_date'])[0];

        /** @var array arreglo que almacenara la lista de cuentas patrimoniales*/
        $records = [];
        array_push($records, [
                'id' => 0,
                'text' =>  "Seleccione...",
            ]);
        /**
         * se realiza la busqueda de manera ordenada en base al codigo
         */
        foreach (AccountingAccount::orderBy('group','ASC')
                                    ->orderBy('subgroup','ASC')
                                    ->orderBy('item','ASC')
                                    ->orderBy('generic','ASC')
                                    ->orderBy('specific','ASC')
                                    ->orderBy('subspecific','ASC')
                                    ->where('active',true)
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
        return view('accounting::reports.index-auxiliary_book', compact('records','year_old'));
    }

    /**
     * vista en la que se genera el reporte en pdf
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $accountId variable con el id de la cuenta
     * @param String $date variable con la fecha para la generación de reporte, formato 'YYYY-mm'
     */

    public function pdf($account_id, $date)
    {

        /** @var Object consulta de la cuenta patrimonial */
        $account = AccountingAccount::find($account_id);

        /** @var Object Objeto que almacena la información de la cuenta padre, si posee */
        $parent_account = $account->getParent( $account->group,
                                   $account->subgroup,
                                   $account->item,
                                   $account->generic,
                                   $account->specific,
                                   $account->subspecific );

        /** @var Object String en el que se formatea la fecha inicial de busqueda */
        $initDate = $date.'-01';

        /** @var Object String en que se almacena el ultimo dia correspondiente al mes */
        $day = date('d',(mktime(0,0,0,explode('-',$date)[1]+1,1,explode('-',$date)[0])-1));

        /** @var Object String en el que se formatea la fecha final de busqueda */
        $endDate = $date.'-'.$day;

        /** @var Object Objeto con los registros de las cuenta patrimonial seleccionada */
        $records = AccountingSeatAccount::with('seating')
                                    ->where('accounting_account_id', $account_id)
                                    ->whereHas('seating', function($query) use ($initDate, $endDate) {
                                        $query->whereBetween('from_date',[$initDate,$endDate])->where('approved',true);
                                    })->orderBy('updated_at','ASC')->get();

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

        $pdf->setType('Libro Auxiliar');
        $pdf->Open();
        $pdf->AddPage();

        $OneSeat = false;
        $html = \View::make('accounting::pdf.accounting_auxiliary_book',compact('pdf','records','account','parent_account','initDate','endDate','currency'))->render();
        $pdf->SetFont('Courier','B',8);

        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->Output("Libro_auxiliar_{$initDate}_{$endDate}.pdf");
    }

    public function get_checkBreak(){
        return $this->PageBreakTrigger;
    }

}
