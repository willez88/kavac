<?php

namespace Modules\Sale\Http\Controllers\Reports;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use App\Models\CodeSetting;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Repositories\ReportRepository;
use Modules\Sale\Models\SaleQuote;
use Modules\Sale\Models\SaleQuoteProduct;
use Modules\Sale\Models\SaleWarehouseInventoryProduct;
use Modules\Sale\Models\SaleWarehouseMovement;
use Modules\Sale\Models\SaleTypeGood;
use App\Models\HistoryTax;
use App\Models\Institution;

/**
 * @class SaleQuoteReportController
 * @brief Controlador de los reportes de Quotes
 *
 * Clase que gestiona la generacion de reportes de quotes
 *
 * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class SaleQuoteReportController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        //$this->middleware('permission:warehouse.report.', ['only' => 'create']);
    }

    /**
     * Muestra un listado para generar el reporte de Quotes
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return Renderable
     */
    public function index()
    {
        return view('sale::reports.sale-report-quote');
    }

    /**
     * Obtiene la lista de quotes en base a los filtros del usuario en el reporte
     *
     * @method    quotesSearch
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     */
    public function quotesSearch(Request $request)
    {
        $filter = $request->all();
        $width = [
          'SaleFormPayment',
          'saleQuoteProduct.saleWarehouseInventoryProduct.SaleSettingProduct',
          'saleQuoteProduct.saleTypeGood',
          'saleQuoteProduct.SaleListSubservices',
        ];
        $quotes = SaleQuote::with($width);
        if (isset($filter['filterDate']) && $filter['filterDate'] == 'specific') {
            if ($filter['dateIni'] != null && $filter['dateIni'] != '') {
                $quotes->whereDate('created_at', '>=', $filter['dateIni']);
            }
            if ($filter['dateEnd'] != null && $filter['dateEnd'] != '') {
                $quotes->whereDate('created_at', '<=', $filter['dateEnd']);
            }
        }
        else if (isset($filter['filterDate']) && $filter['filterDate'] == 'general') {
            if (count($filter['year_init']) > 0) {
                $quotes->where(function($q) use($filter) {
                    foreach ($filter['year_init'] as $year) {
                        $q->whereYear('created_at', '=', $year, 'or');
                    }
                });
            }
            if (count($filter['month_init']) > 0) {
                $quotes->where(function($q) use($filter) {
                    foreach ($filter['month_init'] as $month) {
                        $q->whereMonth('created_at', '=', $month, 'or');
                    }
                });
            }
        }
        if (isset($filter['status']) && $filter['status'] != null && $filter['status'] != '') {
            $quotes->where('status', $filter['status']);
        }
        if (isset($filter['clients']) && count($filter['clients']) > 0) {
            $quotes->whereIn('id_number', $filter['clients']);
        }

        return response()->json(['records' => $quotes->get()], 200);
    }

    /**
     * Genera el archivo PDF en base a los quotes seleccionados por el usuario
     *
     * @method    pdf
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     */
    public function pdf($values=[])
    {
        $width = [
          'SaleFormPayment',
          'saleQuoteProduct.saleWarehouseInventoryProduct.SaleSettingProduct',
          'saleQuoteProduct.saleTypeGood',
          'saleQuoteProduct.SaleListSubservices',
          'saleQuoteProduct.measurementUnit',
          'saleQuoteProduct.Currency',
          'saleQuoteProduct.historyTax',
        ];
        $quotes = SaleQuote::with($width);
        if ($values != '') {
          $ids = explode('+', $values);
          if (count($ids)) {
            $quotes->whereIn('id', $ids);
          }

        }
        /**
         * [$pdf base para generar el pdf]
         * @var [Modules\Accounting\Pdf\Pdf]
        */
        $pdf = new ReportRepository();

        /*
         *  Definicion de las caracteristicas generales de la página pdf
        */
        $institution = null;
        $is_admin = auth()->user()->isAdmin();

        if (!$is_admin && $user_profile && $user_profile['institution']) {
          $institution = Institution::find($user_profile['institution']['id']);
        }
        else {
          $institution = '';
        }

        $pdf->setConfig(['institution' => Institution::first()]);
        $pdf->setHeader('Reporte de Cotizaciones');
        $pdf->setFooter();
        $pdf->setBody('sale::quotes.quotes-pdf', true, [
          'pdf' => $pdf,
          'quotes' => $quotes->get()
        ]);
    }
}
