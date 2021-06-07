<?php

namespace Modules\Sale\Http\Controllers;

use Modules\Sale\Models\SaleSettingFrecuency;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

/**
 * @class FrecuencyController
 * @brief Gestiona información de Periodos de tiempo
 *
 * Controlador para gestionar Periodos de tiempo
 *
 * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class FrecuencyController extends Controller
{
    use ValidatesRequests;
    /**
     * Define la configuración de la clase
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        /*
        $this->middleware('permission:sale.setting.frecuency.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sale.setting.frecuency.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sale.setting.frecuency.delete', ['only' => 'destroy']);
        $this->middleware('permission:sale.setting.frecuency.list', ['only' => 'index']);
        */
    }

    /**
     * Muesta todos los registros de Periodos de tiempo
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Http\JsonResponse con los registros de Periodos de tiempo
     */
    public function index()
    {
        return response()->json(['records' => SaleSettingFrecuency::all()], 200);
    }

    /**
     * Valida y registra un nuevo Periodo de tiempo
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse con mensaje de exito
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
        ]);

        if (!restore_record(SaleSettingFrecuency::class, ['name' => $request->name])) {
            $this->validate($request, [
                'name' => ['unique:frecuencies,name']
            ]);
        }

        /** @var frecuency Objeto con información del Periodo de tiempo registrado */
        $frecuency = SaleSettingFrecuency::updateOrCreate([
            'name' => $request->name
        ]);

        return response()->json(['record' => $frecuency, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del Periodo de tiempo
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  Modules\Sale\Models\SaleSettingFrecuency  $frecuency
     * @return \Illuminate\Http\JsonResponse con mensaje de exito
     */
    public function update(Request $request, SaleSettingFrecuency $frecuency)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100', 'unique:frecuencies,name,' . $frecuency->id]
        ]);

        $frecuency->name = $request->name;
        $frecuency->save();

        return response()->json(['message' => __('Registro actualizado correctamente')], 200);
    }

    /**
     * Elimina el Periodo de tiempo
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @param  Modules\Sale\Models\SaleSettingFrecuency  $frecuency
     * @return \Illuminate\Http\JsonResponse con mensaje de exito
     */
    public function destroy(SaleSettingFrecuency $frecuency)
    {
        $frecuency->delete();
        return response()->json(['record' => $frecuency, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene las frecuencias
     *
     * @method getFrecuencies
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     *
     * @param
     *
     * @return JsonResponse JSON con los datos de los Periodos de tiempo
     */
    public function getFrecuencies()
    {
        return response()->json(template_choices('Modules\Sale\Models\SaleSettingFrecuency', 'name', '', true));
    }
}
