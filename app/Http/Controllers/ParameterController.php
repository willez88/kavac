<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;

/**
 * @class ParameterController
 * @brief Gestiona información para la configuración de parámetros del sistema
 *
 * Controlador para gestionar configuración de parámetros
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class ParameterController extends Controller
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
        /** Establece permisos de acceso del controlador */
        $this->middleware('permission:system.param.setting');
    }

    /**
     * Registra un nuevo parámetro general del sistema
     *
     * @method    store
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @author     William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     *
     * @param     Request    $request    Objeto con información de la petición
     *
     * @return    RedirectResponse     Redirecciona al usuario a la URL previa
     */
    public function store(Request $request)
    {
        /** Validación de parámetro edad laboral permitida que viene del módulo de talento humano */
        $parameter = Parameter::where([
            'required_by' => 'payroll', 'p_key' => $request->p_key
        ])->first();
        if ($parameter) {
            $this->validate(
                $request,
                [
                    'p_value' => ['required', 'integer', 'min:16']
                ],
                [],
                [
                    'p_value' => 'edad laboral permitida'
                ]
            );
            Parameter::updateOrCreate(
                [
                    'p_key' => $request->p_key,
                    'required_by' => 'payroll',
                    'active' => true
                ],
                [
                    'p_value' => $request->p_value
                ]
            );
        }
        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->back();
    }
}
