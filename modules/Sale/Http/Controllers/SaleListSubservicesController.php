<?php
/** [descripción del namespace] */
namespace Modules\Sale\Http\Controllers;

//use Illuminate\Contracts\Support\Renderable;
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
        return response()->json(['records' => SaleListSubservices::with('SaleListSubservicesAttribute')->get()], 200);
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
            foreach ($request->sale_list_subservices_attribute as $att) {
                $attribute = SaleListSubservicesAttribute::create([
                    'value'                 => $att['value'],
                    'sale_list_subservices_id' => $salelistsubservicesMethod->id
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
        //dd($salelistsubservicesMethod);
        $salelistsubservicesMethod = SaleListSubservices::find($id);
        //dd($salelistsubservicesMethod);

        $this->validate($request, [
            'name'                => ['required', 'max:100'],
            'description'         => ['required']
        ]);
        //$salelistsubservicesMethod = new SaleListSubservices;
        //$salelistsubservicesMethod->id                  = $request->id;
        $salelistsubservicesMethod->name                = $request->input('name');
        $salelistsubservicesMethod->description         = $request->input('description');
        $salelistsubservicesMethod->define_attributes   =  !empty($request->define_attributes)
                                          ? $request->input('define_attributes')
                                          : false;
        $salelistsubservicesMethod->save();
        $salelist_subservicesattribute = SaleListSubservicesAttribute::where('sale_list_subservices_id', $salelistsubservicesMethod->id)->get();

        //return $salelistsubservicesMethod;
        /** Busco si en la solicitud se eliminaron atributos registrados anteriormente */
        if ($salelist_subservicesattribute) {
            foreach ($salelist_subservicesattribute as $att) {
                $equal = false;
                foreach ($request->sale_list_subservices_attribute as $attr) {
                    if ($attr['value'] == $att->value) {
                        $equal = true;
                        break;
                    }
                }
                if ($equal == false) {
                    $value = $att->SaleListSubservices();
                    if ($value) {
                        $att->delete();
                    }
                    
                }
            }
        }

        /** Registro los nuevos atributos */
        if ($salelistsubservicesMethod->define_attributes == true) {
            foreach ($request->sale_list_subservices_attribute as $att) {
                $attribute = SaleListSubservicesAttribute::where('value', $att['value'])
                             ->where('sale_list_subservices_id', $salelistsubservicesMethod->id)->first();
                if (is_null($attribute)) {
                    //return $att;
                    $attribute = SaleListSubservicesAttribute::create([
                        'value' => $att['value'],
                        'sale_list_subservices_id' => $salelistsubservicesMethod->id
                    ]);
                }
            }
        };

        return response()->json(['message' => 'Success'], 200);
        //return response()->json(['record' => $salelistsubservicesMethod, 'message' => 'Success'], 200);


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