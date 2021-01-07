<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Tax;
use App\Models\HistoryTax;
use Illuminate\Http\Request;

/**
 * @class TaxController
 * @brief Gestiona información de Impuestos
 *
 * Controlador para gestionar Impuestos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class TaxController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @method  __construct
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:tax.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:tax.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:tax.delete', ['only' => 'destroy']);
        $this->middleware('permission:tax.list', ['only' => 'index']);
    }

    /**
     * Listado de todos los impuestos registrados
     *
     * @method    index
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return    JsonResponse  JSON con el listado de impuestos
     */
    public function index()
    {
        return response()->json(['records' => Tax::with(['histories' => function ($query) {
            return $query->orderBy('operation_date', 'desc')->first();
        }])->get()], 200);
    }

    /**
     * Registra un nuevo impuesto
     *
     * @method    store
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request    $request    Objeto con información de la petición
     *
     * @return    JsonResponse  JSON con el resultado del registro
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:60'],
            'description' => ['required'],
            'operation_date' => ['required', 'date'],
            'percentage' => ['required']
        ]);

        /** @var Tax Objeto con información del impuesto registrado */
        $tax = Tax::create([
            'name' => $request->name,
            'description' => $request->description,
            'affect_tax' => ($request->affect_tax!==null),
            'active' => ($request->active!==null),
        ]);

        HistoryTax::create([
            'operation_date' => $request->operation_date,
            'percentage' => $request->percentage,
            'tax_id' => $tax->id
        ]);

        return response()->json(['record' => $tax, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de un impuesto
     *
     * @method    update
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request    $request    Objeto con información de la petición
     * @param     Tax        $tax        Objeto con información del impuesto a actualizar
     *
     * @return    JsonResponse  JSON con el resultado de la actualización
     */
    public function update(Request $request, Tax $tax)
    {
        $this->validate($request, [
            'name' => ['required', 'max:60'],
            'description' => ['required'],
            'operation_date' => ['required', 'date'],
            'percentage' => ['required']
        ]);

        $tax->name = $request->name;
        $tax->description = $request->description;
        $tax->operation_date = $request->operation_date;
        $tax->percentage = $request->percentage;
        $tax->affect_tax = ($request->affect_tax);
        $tax->active = ($request->active);
        $tax->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Elimina un impuesto
     *
     * @method    destroy
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Tax        $tax    Objeto con información del impuesto a eliminar
     *
     * @return    JsonResponse  JSON con el resultado de la eliminación
     */
    public function destroy(Tax $tax)
    {
        $tax->delete();
        return response()->json(['record' => $tax, 'message' => 'Success'], 200);
    }
}
