<?php
namespace Modules\Sale\Http\Controllers\Reports;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Sale\Models\SaleBill;

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
     * Método que devuelve los datos de las facturas registradas en formato
     * json.
     *
     * @method    vueList
     *
     * @author    Ing. Argenis Osorio <aosorio@cenditel.gob.ve>
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function vueList()
    {
        $bills = SaleBill::get();
        return response()->json(['records' => $bills], 200);
    }
}
