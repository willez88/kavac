<?php
namespace Modules\Sale\Http\Controllers\Reports;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Sale\Models\Profile;
use Modules\Sale\Models\Institution;
use Modules\Sale\Models\SaleBill;

use App\Repositories\ReportRepository;
use Modules\DigitalSignature\Repositories\ReportRepositorySign;
use Auth;

/**
 * @class BillReportController
 * @brief Gestiona los reportes de facturas.
 *
 * Gestiona los reportes de facturas del módulo de Comercialización.
 *
 * @author    Ing. Argenis Osorio <aosorio@cenditel.gob.ve>
 * @license   <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                LICENCIA DE SOFTWARE CENDITEL
 *            </a>
 */
class SaleBillReportController extends Controller
{
    /**
     * Método que carga la vista para visualizar los filtros para los reportes
     * de facturas.
     * 
     * @method    index
     *
     * @author    Ing. Argenis Osorio <aosorio@cenditel.gob.ve>
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function index()
    {
        return view('sale::reports.sale-report-bill');
    }

    /**
     * [descripción del método]
     *
     * @method    filterRecords
     *
     * @author    Daniel Contreras <dcontreras@cenditel.gob.ve>
     *
     * @param     Requert    $request    Informacion de la consulta
     *
     * @return    Response
     */
    public function filterRecords(Request $request){
        $filter = $request->all();

        $records = SaleBill::with(['SaleFormPayment', 'saleBillInventoryProduct' => function ($query) {
                        $query->with(['saleGoodsToBeTraded', 'currency', 'saleListSubservices', 'measurementUnit', 'historyTax',
                            'saleWarehouseInventoryProduct' => function ($q) {
                                $q->with('saleSettingProduct');
                        }]);
                    }]);

        if ($filter['filterDate'] == 'specific') {
            if ($filter['dateIni'] != null && $filter['dateEnd'] != null) {
                $records->whereDate('created_at', '>=', $filter['dateIni'])->whereDate('created_at', '<=', $filter['dateEnd']);
            }
        }
        else if ($filter['filterDate'] == 'general') {
            if ($filter['year_init'] != null && $filter['year_end'] != null && $filter['month_init'] != null && $filter['month_end'] != null) {
                $records->whereYear('created_at', '>=', $filter['year_init'])->whereYear('created_at', '<=', $filter['year_end'])
                        ->whereMonth('created_at', '>=', $filter['month_init'])->whereMonth('created_at', '<=', $filter['month_end']);
            }
        }

        if ($filter['state'] != null && $filter['state'] != 'Todos') {
            $records->where('state', $filter['state']);
        }
        return response()->json([
            'records' => $records->get(),
            'message' => 'success'], 200);
    }

    /**
     * Genera Pdf
     *
     * @author    Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @author    Daniel Contreras <dcontreras@cenditel.gob.ve>
     *
     * @param     Array    $value    Listado de identificadores
     */
    public function pdf($value = [])
    {
        $listIds = json_decode($value);
        // Validar acceso para el registro
        if (!auth()->user()->isAdmin()) {
            $user_profile = Profile::with('institution')->where('user_id', auth()->user()->id)->first();
            if ($report && $report->queryAccess($user_profile['institution']['id'])) {
                return view('errors.403');
            }
        }

        $bills = SaleBill::with(['SaleFormPayment', 'saleBillInventoryProduct' => function ($query) {
                                $query->with(['saleGoodsToBeTraded', 'currency', 'saleListSubservices', 'measurementUnit', 'historyTax',
                                    'saleWarehouseInventoryProduct' => function ($q) {
                                        $q->with('saleSettingProduct');
                                }]);
                            }])->whereIn('id', $listIds)->get()->toArray();

        /**
         * [$pdf base para generar el pdf]
         *
         * @author    Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
         * @author    Daniel Contreras <dcontreras@cenditel.gob.ve>
         *
         * @var [App\Repositories\ReportRepository]
         */
        $pdf = new ReportRepository();

        /*
         *  Definicion de las caracteristicas generales de la página pdf
         */
        if (auth()->user()->isAdmin()) {
            $institution = Institution::first();
        } else {
            $institution = Institution::find($user_profile->institution->id);
        }
        // dd($bills);
        $pdf->setConfig(['institution' => $institution, 'urlVerify' => url('/sale/reports/bills/pdf/'.$value)]);
        $pdf->setHeader('Reporte de comercialización', 'Reporte de facturas');
        $pdf->setFooter(true, $institution->rif.' '.$institution->legal_address);
        $pdf->setBody('sale::pdf.bill-reports', true, [
            'pdf'      => $pdf,
            'records'  => $bills,
        ]);
    }
}
