<?php
/** [descripción del namespace] */
namespace Modules\Sale\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Sale\Models\SaleListSubservicesAttribute;
use Modules\Sale\Models\SaleListSubservices;

/**
 * @class SaleListSubservicesController
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class SaleListSubservicesController extends Controller
{
    use ValidatesRequests;
    /**
     * Define la configuración de la clase
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     */

    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador *//*
        $this->middleware('permission:sale.payment.method.list', ['only' => 'index']);
        $this->middleware('permission:sale.payment.method.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sale.payment.method.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sale.payment.method.delete', ['only' => 'destroy']);*/
    }

    /**
     * Muestra todos la Lista de subservicios
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     * @return JsonResponse    Json con los datos
     */
    public function index()
    {
        return response()->json(['records' => SaleListSubservices::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('sale::create');
    }

    /**
     * Valida y registra un nuevo metodo de lista de subsevicios
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return JsonResponse        Json: objeto guardado y mensaje de confirmación de la operación
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'description' => ['required', 'max:200']
        ]);
        $salelistsubservicesMethod = SaleListSubservices::create([
            'name' => $request->name,
            'description' => $request->description,
            'define_attributes'   => !empty($request->define_attributes)
                                        ? $request->define_attributes
                                        : false
        ]);

        if ($salelistsubservicesMethod->define_attributes) {
            foreach ($request->sale_lists_subservices_attribute as $att) {
                $attribute = SaleListSubservicesAttribute::create([
                    'name'                 => $att['name'],
                    'sale_type_good_id' => $salelistsubservicesMethod->id
                ]);
            }
        };

        return response()->json(['record' => $salelistsubservicesMethod, 'message' => 'Success'], 200);
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
     * Actualiza la información del metodo de lista de subsevicios
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request   Solicitud con los datos a actualizar
     * @param  integer $id                          Identificador del datos a actualizar
     * @return JsonResponse        Json con mensaje de confirmación de la operación
     */
    public function update(Request $request, $id)
    {
        $salelistsubservicesMethod = SaleListSubservices::find($id);
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'description' => ['nullable', 'max:200']
        ]);
        $salelistsubservicesMethod->name  = $request->name;
        $salelistsubservicesMethod->description = $request->description;
        $salelistsubservicesMethod->save();
        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina el metodo de lista de subsevicios
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     * @param  integer $id                      Identificador del metodo de lista de subsevicios a eliminar
     * @return JsonResponse    Json: objeto eliminado y mensaje de confirmación de la operación
     */
    public function destroy($id)
    {
        $salelistsubservicesMethod = SaleListSubservices::find($id);
        $salelistsubservicesMethod->delete();
        return response()->json(['record' => $salelistsubservicesMethod, 'message' => 'Success'], 200);
    }
/**
    * Obtiene los Subservicios registrados
    *
    * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
    * @return \Illuminate\Http\JsonResponse    Json con los datos de los Subservicios registrados
    */
    public function getSaleListSubServicesMethod()
    {
        return response()->json(template_choices('Modules\Sale\Models\SaleListSubservices', 'name', '', true));
    }
}
