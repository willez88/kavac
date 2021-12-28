<?php
namespace Modules\Sale\Http\Controllers\Reports;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Modules\Sale\Models\SaleService;

/**
 * @class SaleServiceRequestController
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class SaleServiceRequestController extends Controller
{
    /**
     * [descripción del método]
     *
     * @method    index
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function index()
    {
        return view('sale::reports.sale-report-service-request');
    }

    /**
     * [descripción del método]
     *
     * @method    create
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function create()
    {
        return view('sale::create');
    }

    /**
     * [descripción del método]
     *
     * @method    store
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     object    Request    $request    Objeto con información de la petición
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * [descripción del método]
     *
     * @method    show
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function show($id)
    {
        return view('sale::show');
    }

    /**
     * [descripción del método]
     *
     * @method    edit
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function edit($id)
    {
        return view('sale::edit');
    }

    /**
     * [descripción del método]
     *
     * @method    update
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     object    Request    $request         Objeto con datos de la petición
     * @param     integer   $id        Identificador del registro
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * [descripción del método]
     *
     * @method    destroy
     *
     * @author    [nombre del autor] [correo del autor]
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function destroy($id)
    {
        //
    }

    /**
     * [descripción del método]
     *
     * @method    filterRecords
     *
     * @author    Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     *
     * @param     Requert    $request    Informacion de la consulta
     *
     * @return    Response
     */
    public function filterRecords(Request $request){
        $filter = $request->all();

        $records = SaleService::with(['SaleServiceRequirement','saleClient', 'payrollStaff']);
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

        if ($filter['status'] != null && $filter['status'] != 'Todos') {
            $records->where('status', $filter['status']);
        }
        return response()->json([
            'records' => $records->get(),
            'message' => 'success'], 200);
    }

    public function pdf($value=[])
    {
        return response()->json([
            // 'records' => $records->get(),
            'result' => true,
            'message' => 'success'], 200);
        dd(json_decode($value));
    }
}
