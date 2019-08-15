<?php

namespace Modules\Accounting\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Accounting\Models\AccountingReportHistory;
use Modules\Accounting\Models\AccountingSeatAccount;
use Modules\Accounting\Models\AccountingSeat;
use Modules\Accounting\Models\Currency;
use Modules\Accounting\Models\Setting;
use Modules\Accounting\Pdf\Pdf;
use Auth;

/**
 * @class AccountingReportPdfAnalyticalMajorController
 * @brief Controlador para la generación del reporte de Mayor Analítico
 *
 * Clase que gestiona el reporte de mayor analítico
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AccountingReportPdfAnalyticalMajorController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:accounting.report.analiticalmajor', ['only' => ['index', 'getAccAccount', 'pdf']]);
    }

    /**
     * Consulta y formatea las cuentas en un rango determinado
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  $initDate fecha inicial para iniciar la busqueda, formato(YYYY-mm)
     * @param  $endYear año del fin del rango de busqueda
     * @param  $endMonth mes del fin del rango de busqueda
     * @return Array con las cuentas patrimoniales
     */
    public function filter_accounts($initDate, $endYear, $endMonth)
    {

        /** @var Object String en el que se formatea la fecha inicial de busqueda */
        $initDate = $initDate.'-01';

        /** @var Object String en que se almacena el ultimo dia correspondiente al mes */
        $endDay = date('d', (mktime(0, 0, 0, $endMonth+1, 1, $endYear)-1));

        /** @var Object String en el que se formatea la fecha final de busqueda */
        $endDate = $endYear.'-'.$endMonth.'-'.$endDay;

        /** @var Object Objeto en el que se almacena la consulta de las cuentas con relación hacia asientos contables en un rango de fecha */
        $RecordArr = AccountingSeatAccount::with('seating', 'account')->whereHas('seating', function ($query) use ($initDate, $endDate) {
            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
        })->orderBy('updated_at', 'ASC')->get();
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
        function build_sorter()
        {
            return function ($a, $b) {
                return strnatcmp($a->getCode(), $b->getCode());
            };
        }

        usort($records, build_sorter());

        /**
        Se formatean los datos de las cuentas
        */
        array_push($arrAux, [
                'id_record' => 0,
                'text' => 'Seleccione...',
                'id' => 0,
            ]);
        
        $index = 1;
        foreach ($records as $account) {
            array_push($arrAux, [
                'id_record' => $account->id,
                'text' => "{$account->getCode()} - {$account->denomination}",
                'id' => $index,
            ]);
            $index += 1;
        }
        return $arrAux;
    }

    /**
     * ruta para actualizar el listado de cuentas patrimoniales en un rango de fecha determinado
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  Request $request Objeto con datos del rango de busqueda de las cuentas
     * @return Response JSON con array de las cuentas patrimoniales
     */
    public function getAccAccount(Request $request)
    {
        $this->validate($request, [
            'initMonth' => 'required',
            'initYear' => 'required',
            'endMonth' => 'required',
            'endYear' => 'required',
        ]);
        return response()->json(['records' => $this->filter_accounts(
            $request->initYear.'-'.$request->initMonth,
            $request->endYear,
            $request->endMonth
        )]);
    }

    /**
     * vista en la que se genera el reporte en pdf
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param String $initAcc variable con el index en el array de la cuenta de inicio
     * @param String $endAcc variable con el index en el array de la cuenta final
     */
    public function pdf($initDate, $endDate, $initAcc, $endAcc = null)
    {
        /** @var String para almacenar una copia de la fecha inicial */
        $date_i = $initDate;

        /** @var String para almacenar una copia de la fecha final */
        $date_e = $endDate;

        /** @var String para almacenar una copia de la fecha final */
        $init_a = $initAcc;

        $initAcc = (int)$initAcc;

        /** @var Array Arreglo asociativo con la información base (id, id y denomination) de las cuentas patrimoniales */
        $accountRecords = $this->filter_accounts($initDate, explode('-', $endDate)[0], explode('-', $endDate)[1]);

        /** @var Object String en el que se formatea la fecha inicial de busqueda */
        $initDate = $initDate.'-01';

        /** @var Object String en que se almacena el ultimo dia correspondiente al mes */
        $endDay = date('d', (mktime(0, 0, 0, explode('-', $endDate)[1]+1, 1, explode('-', $endDate)[0])-1));

        /** @var Object String en el que se formatea la fecha final de busqueda */
        $endDate = explode('-', $endDate)[0].'-'.explode('-', $endDate)[1].'-'.$endDay;

        if (isset($endAcc) && $endAcc < $initAcc) {
            $endAcc = (int)$endAcc;
            $aux = $initAcc;
            $initAcc = $endAcc;
            $endAcc = $aux;
        }

        /** @var EndIndex indice de la cuenta desde donde finalizara la busqueda */
        $EndIndex = $initAcc;

        if (isset($endAcc)) {
            $EndIndex = $endAcc;
        }

        /** @var Object Objeto con los registros de las cuentas patrimoniales seleccionadas */
        $records = [];

        for (; $initAcc <= $EndIndex; $initAcc++) {
            $id = $accountRecords[$initAcc]['id_record'];
            array_push($records, AccountingSeatAccount::with('seating', 'account')
                                                        ->where('accounting_account_id', $id)
                                                        ->whereHas('seating', function ($query) use ($initDate, $endDate) {
                                                            $query->whereBetween('from_date', [$initDate,$endDate])->where('approved', true);
                                                        })->orderBy('updated_at', 'ASC')->get());
        }

        // Se crea o actualiza el registro en la basde de datos para el historial
        $url = 'AnalyticalMajor/pdf/'.$date_i.'/'.$date_e.'/'.$init_a;

        if (isset($endAcc)) {
            $url .= '/'.$endAcc;
        }

        AccountingReportHistory::updateOrCreate(
            [
                                                    'name' => 'Mayor Analítico',
                                                    'report' => 2
                                                ],
            [
                                                    'url' => $url,
                                                ]
        );

        /** @var Object configuración general de la apliación */
        $setting = Setting::all()->first();

        /** @var Object con la información de la modena por defecto establecida en la aplicación */
        $currency = Currency::where('default', true)->first();

        /** @var Object Objeto base para generar el pdf */
        $pdf = new Pdf('L', 'mm', 'Letter');
        
        /*
         *  Definicion de las caracteristicas generales de la página
         */

        if (isset($setting) and $setting->report_banner == true) {
            $pdf->SetMargins(10, 65, 10);
        } else {
            $pdf->SetMargins(10, 55, 10);
        }
        $pdf->SetHeaderMargin(10);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->SetAutoPageBreak(true, PDF_MARGIN_FOOTER);

        $pdf->setType('Asientos Contables');
        $pdf->Open();
        $pdf->AddPage();

        $OneSeat = false;
        
        $html = \View::make('accounting::pdf.accounting_analytical_major_pdf', compact('pdf', 'records', 'initDate', 'endDate', 'currency'))->render();
        $pdf->SetFont('Courier', 'B', 8);

        $pdf->writeHTML($html, true, false, true, false, '');


        $pdf->Output("MayorAnalítico_{$initDate}_{$endDate}.pdf");
    }

    public function get_checkBreak()
    {
        return $this->PageBreakTrigger;
    }
}
