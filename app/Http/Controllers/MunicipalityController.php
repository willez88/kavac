<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Municipality;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Rules\UniqueMunicipalityCode;

/**
 * @class MunicipalityController
 * @brief Gestiona información de Municipios
 *
 * Controlador para gestionar Municipios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class MunicipalityController extends Controller
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
        $this->middleware('permission:municipality.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:municipality.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:municipality.delete', ['only' => 'destroy']);
        $this->middleware('permission:municipality.list', ['only' => 'index']);
    }

    /**
     * Listado de todos los registros de los Municipios
     *
     * @method  index
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return JsonResponse     JSON con información de los municipios registrados
     */
    public function index()
    {
        return response()->json(['records' => Municipality::with('estate')->get()], 200);
    }

    /**
     * Registra un nuevo Municipio
     *
     * @method  store
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request  $request    Objeto con información de la petición
     *
     * @return JsonResponse         JSON con datos de respuesta a la petición
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'code' => ['required', 'max:10', new UniqueMunicipalityCode],
            'estate_id' => ['required']
        ]);

        if (!restore_record(Municipality::class, ['name' => $request->name, 'estate_id' => $request->estate_id])) {
            $this->validate($request, [
                'name' => Rule::unique('municipalities')->where(function ($query) use ($request) {
                    return $query->where('estate_id', $request->estate_id)->where('name', $request->name);
                })
            ]);
        }

        /** @var Municipality Objeto con información del municipio registrado */
        $municipality = Municipality::updateOrCreate([
            'name' => $request->name,
            'estate_id' => $request->estate_id
        ], [
            'code' => $request->code
        ]);

        return response()->json(['record' => $municipality, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del Municipio
     *
     * @method  update
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Request  $request                Objeto con información de la petición
     * @param  Municipality  $municipality      Objeto con información del municipio a actualizar
     *
     * @return JsonResponse     JSON con información del resultado de la actualización del municipio
     */
    public function update(Request $request, Municipality $municipality)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'code' => ['required', 'max:10'],
            'estate_id' => ['required']
        ]);

        $municipality->name = $request->name;
        $municipality->code = $request->code;
        $municipality->estate_id = $request->estate_id;
        $municipality->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Elimina un Municipio
     *
     * @method  destroy
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param  Municipality  $municipality  Objeto con información del municipio a eliminar
     *
     * @return JsonResponse     JSON con el resultado de la eliminación
     */
    public function destroy(Municipality $municipality)
    {
        $municipality->delete();
        return response()->json(['record' => $municipality, 'message' => 'Success'], 200);
    }
}
