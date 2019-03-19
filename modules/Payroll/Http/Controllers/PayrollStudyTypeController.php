<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollStudyType;

/**
 * @class PayrollStudyTypeController
 * @brief Controlador de tipo de estudio
 *
 * Clase que gestiona los tipos de estudios
 *
 * @author William Páez (wpaez at cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class PayrollStudyTypeController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:payroll.study.types.list', ['only' => 'index']);
        $this->middleware('permission:payroll.study.types.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.study.types.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.study.types.delete', ['only' => 'destroy']);
    }

    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $study_types = PayrollStudyType::all();
        return view('payroll::study-types.index', compact('study_types'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header = [
            'route' => 'study-types.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::study-types.create-edit', compact('header'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'nullable|max:200'
        ]);
        $study_type = new PayrollStudyType;
        $study_type->name  = $request->name;
        $study_type->description = $request->description;
        $study_type->save();
        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('study-types.index');
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('payroll::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit(PayrollStudyType $study_type)
    {
        $header = [
            'route' => ['study-types.update', $study_type], 'method' => 'PUT', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::study-types.create-edit', compact('study_type','header'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, PayrollStudyType $study_type)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'description' => 'nullable|max:200'
        ]);
        $study_type->name  = $request->name;
        $study_type->description = $request->description;
        $study_type->save();
        $request->session()->flash('message', ['type' => 'update']);
        return redirect()->route('study-types.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request, PayrollStudyType $study_type)
    {
        if ($request->ajax())
        {
            $study_type->delete();
            $request->session()->flash('message', ['type' => 'destroy']);
            return response()->json(['result' => true]);
        }
        return redirect()->route('study-types.index');
    }
}
