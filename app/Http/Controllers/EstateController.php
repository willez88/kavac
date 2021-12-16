<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Estate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\UniqueEstateCode;

/**
 * @class EstateController
 * @brief Gestiona información de Estados
 *
 * Controlador para gestionar Estados
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class EstateController extends Controller
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
        $this->middleware('permission:estate.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:estate.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:estate.delete', ['only' => 'destroy']);
        $this->middleware('permission:estate.list', ['only' => 'index']);
    }

    /**
     * Listado de todos los registros de los Estados
     *
     * @method    index
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return    JsonResponse      JSON con información de los Estados registrados
     */
    public function index()
    {
        return response()->json(['records' => Estate::with('country')->get()], 200);
    }

    /**
     * Registra un nuevo Estado
     *
     * @method    store
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param     Request    $request    Objeto con información de la petición
     *
     * @return    JsonResponse      JSON con información de respuesta a la petición
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'code' => ['required', 'max:10', new UniqueEstateCode],
            'country_id' => ['required']
        ]);

        if (!restore_record(Estate::class, ['name' => $request->name, 'country_id' => $request->country_id])) {
            $this->validate($request, [
                'name' => Rule::unique('estates')->where(function ($query) use ($request) {
                    return $query->where([
                        'country_id' => $request->country_id, 'name' => $request->name
                    ]);
                })
            ]);
        }

        /** @var Estate Objeto con información del Estado */
        $estate = Estate::updateOrCreate([
            'name' => $request->name,
            'country_id' => $request->country_id
        ], [
            'code' => $request->code
        ]);

        return response()->json(['record' => $estate, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del Estado
     *
     * @method  update
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request  $request    Objeto con información de la petición
     * @param  Estate   $estate     Objeto con información del Estado a actualizar
     *
     * @return JsonResponse     JSON con datos de respuesta a la petición
     */
    public function update(Request $request, Estate $estate)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'code' => ['required', 'max:10'],
            'country_id' => ['required']
        ]);

        $estate->name = $request->name;
        $estate->code = $request->code;
        $estate->country_id = $request->country_id;
        $estate->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Elimina un Estado
     *
     * @method  destroy
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Estate  $estate  Objeto con información del Estado a eliminar
     *
     * @return JsonResponse     JSON con datos del Estado eliminado
     */
    public function destroy(Estate $estate)
    {
        $estate->delete();
        return response()->json(['record' => $estate, 'message' => 'Success'], 200);
    }
}
