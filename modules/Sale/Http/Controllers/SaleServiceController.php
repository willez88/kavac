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
        $this->validate($request, [
            'name' => ['required'],
            'organization' => ['required'],
            'description' => ['required'],
            'resume' => ['required'],
            'sale_client_id' => ['required'],
            'sale_goods_to_be_traded' => ['required'],
        ]);

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
                'name' => $request->input('name'),
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
}
