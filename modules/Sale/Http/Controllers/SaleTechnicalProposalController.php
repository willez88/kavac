<?php
/** [descripción del namespace] */
namespace Modules\Sale\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;

use Modules\Sale\Models\SaleService;
use Modules\Sale\Models\SaleTechnicalProposal;
use Modules\Sale\Models\SaleProposalRequirement;
use Modules\Sale\Models\SaleProposalSpecification;
use Modules\Sale\Models\SaleGanttDiagram;
use Modules\Sale\Models\SaleGanttDiagramStage;
use Modules\Asset\Models\AssetAsignation;

/**
 * @class SaleTechnicalProposalController
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class SaleTechnicalProposalController extends Controller
{
    use ValidatesRequests;
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
        //
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
        //
    }

    /**
     * Muestra el formulario para completar la propuesta técnica
     *
     * @author    Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param     Integer                  $id    Identificador único del bien a asignar
     * @return    Renderable
     */
    public function saleCompleteTechnicalProposal($id)
    {
        $saleTechnicalProposal = SaleService::with('saleTechnicalProposal')->find($id);
        return view('sale::technical-proposals.create', compact('saleTechnicalProposal'));
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
        $this->validate($request, [
            'sale_list_subservices' => ['required'],
            'duration'              => ['required'],
            'frecuency_id'          => ['required'],
            'stage'                 => ['required'],
            'sale_gantt_diagram_id' => ['required'],
            'activity'              => ['required'],
            'start_date'            => ['required'],
            'end_date'              => ['required'],
            'payroll_staff_id'      => ['required'],
        ]);

        $technicalProposal = SaleTechnicalProposal::create([
            'sale_service_id' => $request->input('sale_service_id'),
            'duration' => $request->input('duration'),
            'frecuency_id' => $request->input('frecuency_id'),
            'asset_asignations' => $request->input('asset_asignations'),
            'sale_list_subservices' => $request->input('sale_list_subservices'),
            'payroll_staffs' => $request->input('payroll_staffs'),
        ]);

        if ($request->requirements && !empty($request->requirements)) {
            foreach ($request->requirements as $requirement) {
                $proposalRequirement = SaleProposalRequirement::create([
                    'name'          => $requirement['name'],
                    'sale_technical_proposal_id' => $technicalProposal->id
                ]);
            }
        }

        if ($request->specifications && !empty($request->specifications)) {
            foreach ($request->specifications as $specification) {
                $proposalSpecification = SaleProposalSpecification::create([
                    'name'          => $specification['name'],
                    'sale_technical_proposal_id' => $technicalProposal->id
                ]);
            }
        }

        if ($request->activities && !empty($request->activities)) {
            foreach ($request->activities as $activity) {
                $ganttDiagram = SaleGanttDiagram::create([
                    'activity' => $request->input('activity'),
                    'description' => $request->input('description'),
                    'start_date' => $request->input('start_date'),
                    'end_date' => $request->input('end_date'),
                    'percentage' => $request->input('percentage'),
                    'payroll_staff_id' => $request->input('payroll_staff_id'),
                    'sale_technical_proposal_id' => $technicalProposal->id,
                ]);
            }
        }

        if ($request->stages && !empty($request->stages)) {
            foreach ($request->stages as $stage) {
                $ganttStage = SaleGanttDiagramStage::create([
                    'stage'          => $ganttStage['stage'],
                    'description'    => $ganttStage['description'],
                    'sale_gantt_diagram_id' => $ganttDiagram->id
                ]);
            }
        }

        if (is_null($technicalProposal)) {
            $request->session()->flash(
                'message',
                [
                    'type' => 'other',
                    'title' => 'Alerta',
                    'icon' => 'screen-error',
                    'class' => 'growl-danger',
                    'text' => 'No se pudo completar la operación.'
                ]
            );
        } else {
            $request->session()->flash('message', ['type' => 'store']);
        }
        return response()->json(['result' => true, 'redirect' => route('sale.services.index')], 200);
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
     * Muestra una lista de los bienes asignados a un trabajador para los select
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return JsonResponse
     */

    public function getAsignationStaffs()
    {
        $records = [];
        $assetAsignations = AssetAsignation::with('payrollStaff')->orderBy('id', 'ASC')
                                    ->get();

        array_push($records, ['id' => '', 'text' => 'Seleccione...']);
        
        foreach ($assetAsignations as $assetAsignation) {

            array_push($records, [
                'id'                   => $assetAsignation->id,
                'text'                 => $assetAsignation->payrollStaff->first_name . ' ' .
                                            $assetAsignation->payrollStaff->last_name . ' - ' .$assetAsignation->payrollStaff->id_number,

            ]);
        }
        return response()->json(['records' => $records], 200);
    }
}
