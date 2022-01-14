<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\DB;
use App\Models\CodeSetting;

use Modules\Sale\Models\SaleService;
use Modules\Sale\Models\SaleServiceRequirement;
use Modules\Sale\Models\SaleTechnicalProposal;

/**
 * @class SaleServiceController
 * @brief Controlador de solicitud de servicios
 *
 * Clase que gestiona las solicitudes de servicios del módulo de comercialización
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class SaleServiceController extends Controller
{
    use ValidatesRequests;

    /**
     * Arreglo con las reglas de validación sobre los datos de un formulario
     * @var Array $validateRules
     */
    protected $validateRules;

    /**
     * Arreglo con los mensajes para las reglas de validación
     * @var Array $messages
     */
    protected $messages;

    /**
     * Define la configuración de la clase
     *
     * @author    Daniel Contreras <dcontreras@cenditel.gob.ve>>
     */
    public function __construct()
    {
        /** Define las reglas de validación para el formulario */
        $this->validateRules = [
            'sale_client_id'          => ['required'],
            'organization'            => ['required'],
            'description'             => ['required'],
            'sale_goods_to_be_traded' => ['required'],
            'resume'                  => ['required'],
        ];

        /** Define los mensajes de validación para las reglas del formulario */
        $this->messages = [
            'sale_client_id.required'          => 'El campo cliente es obligatorio.',
            'organization.required'            => 'El campo organización es obligatorio.',
            'description.required'             => 'El campo descripción de la actividad económica es obligatorio.',
            'sale_goods_to_be_traded.required' => 'El campo servicio es obligatorio.',
            'resume.required'                  => 'El campo resumen de la solicitud es obligatorio.',
        ];
    }

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
        return view('sale::services.list');
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
        return view('sale::services.create');
    }

    /**
     * Registra un nueva solicitud de servicios
     *
     * @method    store
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */
     
    public function store(Request $request)
    {
        $this->validate($request, $this->validateRules, $this->messages);

        $codeSetting = CodeSetting::where('table', 'sale_services')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('sale.settings.index')], 200);
        }

        $code  = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );

        DB::transaction(function () use ($request, $code) {
            $data_request = SaleService::create([
                'code' => $code,
                'status' => 'Pendiente',
                'organization' => $request->input('organization'),
                'description' => $request->input('description'),
                'resume' => $request->input('resume'),
                'sale_client_id' => $request->input('sale_client_id'),
                'sale_goods_to_be_traded' => $request->input('sale_goods_to_be_traded'),
            ]);

            if ($request->requirements && !empty($request->requirements)) {
                foreach ($request->requirements as $requirement) {
                    $serviceRequirement = SaleServiceRequirement::create([
                        'name'          => $requirement['name'],
                        'sale_service_id' => $data_request->id
                    ]);
                }
            }
        });
        $sale_service = SaleService::where('code', $code)->first();
        if (is_null($sale_service)) {
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
     * Muestra el formulario para editar una solicitud de servicio
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  Integer $id Identificador único del ingreso de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function edit($id)
    {
        $services = SaleService::find($id);
        return view('sale::services.create', compact("services"));
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
        $saleService = SaleService::with('SaleServiceRequirement')->find($id);
        $this->validate($request, $this->validateRules, $this->messages);

        $saleService->organization            = $request->input('organization');
        $saleService->description             = $request->input('description');
        $saleService->resume                  = $request->input('resume');
        $saleService->sale_client_id          = $request->input('sale_client_id');
        $saleService->sale_goods_to_be_traded = $request->input('sale_goods_to_be_traded');

        $saleService->save();

        $serviceRequirement = SaleServiceRequirement::where('sale_service_id', $saleService->id)->get();

        foreach ($saleService->SaleServiceRequirement as $requirement) {
            $requirement->delete();
        }
        if ($saleService->SaleServiceRequirement == true) {
            foreach ($request->sale_service_requirement as $requirement) {
                $serviceRequirement = SaleServiceRequirement::create([
                    'name'          => $requirement['name'],
                    'sale_service_id' => $saleService->id
                ]);
            }
        }

        if (is_null($saleService)) {
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
            $request->session()->flash('message', ['type' => 'update']);
        }
        return response()->json(['result' => true, 'redirect' => route('sale.services.index')], 200);
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
        /**
         * Objeto con la información asociada al modelo SaleService
         * @var Object $saleService
         */
        $saleService = SaleService::find($id);
        if ($saleService) {
            $saleService->delete();
            return response()->json(['result' => true, 'redirect' => route('sale.services.index'), 'message' => 'Success'], 200);
        }
    }

    /**
     * Obtiene un listado de las solicitudes registradas
     */
    public function vueList()
    {
        return response()->json(['records' => SaleService::with(['SaleServiceRequirement',
            'saleClient', 'payrollStaff'])->get()], 200);
    }

    public function vueInfo($id)
    {
        $saleService = SaleService::where('id', $id)->with(['SaleServiceRequirement',
            'saleClient', 'payrollStaff'])->first();
        return response()->json(['record' => $saleService], 200);
    }

    public function approved(Request $request, $id)
    {
        $this->validate($request, [
            'payroll_staff_id' => ['required'],
        ]);
        $saleService = SaleService::find($id);
        $saleService->status = 'Aprobado';
        $saleService->payroll_staff_id  = $request->payroll_staff_id;

        $saleService->save();

        $technicalProposal = SaleTechnicalProposal::create([
            'sale_service_id' => $saleService->id,
            'status' => 'En proceso'
        ]);

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('sale.services.index')], 200);
    }

    public function rejected(Request $request, $id)
    {
        $saleService = SaleService::find($id);
        $saleService->status = 'Rechazado';

        $saleService->save();

        $technicalProposal = SaleTechnicalProposal::where('sale_service_id', $id)->first();
        if($technicalProposal) {
            $technicalProposal->delete();
        }

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('sale.services.index')], 200);
    }

    /**
     * Obtiene un listado de los servicios dependiendo si fuerón aprobados o rechazados
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vuePendingList($status)
    {
        $saleService = SaleService::with(['SaleServiceRequirement',
            'saleClient', 'payrollStaff', 'saleTechnicalProposal' => function ($query) {
                $query->with(['saleService', 'saleProposalSpecification', 'saleProposalRequirement',
                                'saleGanttDiagram' => function ($query) {
                                    $query->with(['saleGanttDiagramStage','payrollStaff']);
                                }]);
                            }])->where('status', $status)->get();

        if ($status == 'Aprobado') {
            $records = [];
            foreach ($saleService as $service) {
                $technicalProposal = $service->saleTechnicalProposal;

                foreach ($technicalProposal as $proposal) {
                    if ($proposal) {
                        array_push($records, $service);
                    }
                }
            }

            return response()->json(['records' => $records], 200);
        } else {
            return response()->json(['records' => $saleService], 200);
        }
    }
}
