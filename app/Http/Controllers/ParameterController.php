<?php

/** Controladores base de la aplicación */
namespace App\Http\Controllers;

use App\Models\Parameter;
use Illuminate\Http\Request;

class ParameterController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct()
    {
        /** Establece permisos de acceso del controlador */
        $this->middleware('permission:system.param.setting');
    }

    /**
     * Valida y registra un nuevo parámetro general del sistema
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request $request    Solicitud con los datos a guardar
     * @return \Illuminate\Http\RedirectResponse    Redirecciona a la url anterior
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'p_value' => ['required', 'integer', 'min:1']
        ]);
        Parameter::updateOrCreate(
            [
                'p_key' => 'work_age',
                'required_by' => 'payroll',
                'active' => true
            ],
            [
                'p_value' => $request->p_value
            ]
        );
        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->back();
    }
}
