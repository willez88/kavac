<?php

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
 * @class SaleServiceController
 * @brief Controlador de propuestas técnicas
 *
 * Clase que gestiona las propuestas técnicas del módulo de comercialización
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
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
     * Registra o actualiza las propuestas técnicas
     *
     * @method    update
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */
    public function update(Request $request, $id)
    {
        $technicalProposal = SaleTechnicalProposal::with(['saleProposalSpecification', 'saleProposalRequirement',
                                                        'saleGanttDiagram'])->where('sale_service_id', $id)
                                                        ->first();
        $this->validate($request, [
            'sale_list_subservices' => ['required'],
            'frecuency_id' => ['required'],
            'duration' => ['required'],
        ]);

        $technicalProposal->sale_service_id       = $request->input('sale_service_id');
        $technicalProposal->duration              = $request->input('duration');
        $technicalProposal->frecuency_id          = $request->input('frecuency_id');
        $technicalProposal->sale_list_subservices = $request->input('sale_list_subservices');
        $technicalProposal->payroll_staffs        = $request->input('payroll_staffs');
        $technicalProposal->status                = 'Culminada';

        $technicalProposal->save();

        foreach ($technicalProposal->saleProposalRequirement as $requirement) {
            $requirement->delete();
        }

        foreach ($technicalProposal->saleProposalSpecification as $specification) {
            $specification->delete();
        }

        foreach ($technicalProposal->saleGanttDiagram as $ganttDiagram) {
            $ganttDiagram->delete();
        }

        if ($request->requirements && !empty($request->requirements)) {
            foreach ($request->requirements as $requirement) {
                $proposalRequirement = SaleProposalRequirement::updateOrCreate([
                    'name'          => $requirement['name'],
                    'sale_technical_proposal_id' => $technicalProposal->id
                ]);
            }
        }

        if ($request->specifications && !empty($request->specifications)) {
            foreach ($request->specifications as $specification) {
                $proposalSpecification = SaleProposalSpecification::updateOrCreate([
                    'name'          => $specification['name'],
                    'sale_technical_proposal_id' => $technicalProposal->id
                ]);
            }
        }

        if ($request->activities && !empty($request->activities)) {
            foreach ($request->activities as $activity) {
                $ganttDiagram = SaleGanttDiagram::updateOrCreate([
                    'activity' => $activity['name'],
                    'description' => $activity['description'],
                    'start_date' => $activity['start_date'],
                    'end_date' => $activity['end_date'],
                    'percentage' => $activity['percentage'],
                    'payroll_staff_id' => $activity['payroll_staff_id'],
                    'sale_technical_proposal_id' => $technicalProposal->id,
                ]);

                $ganttStage = SaleGanttDiagramStage::updateOrCreate([
                    'stage'          => $activity['stage']['stage'],
                    'description'    => $activity['stage']['description'],
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
     * Elimina una propuesta técnica
     *
     * @method    destroy
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     *
     * @param     integer    $id    Identificador del registro
     *
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */
    public function destroy($id)
    {
        $technicalProposal = SaleTechnicalProposal::where('sale_service_id', $id)->first();
        if ($technicalProposal) {
            $technicalProposal->delete();
            return response()->json(['result' => true, 'redirect' => route('sale.services.index'), 'message' => 'Success'], 200);
        }
    }

    public function vueInfo($id)
    {
        $technicalProposal = SaleTechnicalProposal::where('sale_service_id', $id)->with(['saleService',
            'saleProposalSpecification', 'saleProposalRequirement', 'saleGanttDiagram' => function ($query) {
                $query->with(['saleGanttDiagramStage', 'payrollStaff']);
            }])->first();
        return response()->json(['record' => $technicalProposal], 200);
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
