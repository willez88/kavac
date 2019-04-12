<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollLanguageLevel;

/**
 * @class PayrollLanguageLevelController
 * @brief Controlador del nivel de idioma
 *
 * Clase que gestiona los niveles de idioma
 *
 * @author William Páez <wpaez at cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollLanguageLevelController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:payroll.language.levels.list', ['only' => 'index']);
        $this->middleware('permission:payroll.language.levels.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.language.levels.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.language.levels.delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $language_levels = PayrollLanguageLevel::all();
        return view('payroll::language-levels.index', compact('language_levels'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header = [
            'route' => 'payroll.language-levels.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::language-levels.create-edit', compact('header'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100'
        ]);
        $language_level = new PayrollLanguageLevel;
        $language_level->name  = $request->name;
        $language_level->save();
        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('payroll.language-levels.index');
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
    public function edit(PayrollLanguageLevel $language_level)
    {
        $header = [
            'route' => ['payroll.language-levels.update', $language_level], 'method' => 'PUT', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::language-levels.create-edit', compact('language_level','header'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, PayrollLanguageLevel $language_level)
    {
        $this->validate($request, [
            'name' => 'required|max:100'
        ]);
        $language_level->name  = $request->name;
        $language_level->save();
        $request->session()->flash('message', ['type' => 'update']);
        return redirect()->route('payroll.language-levels.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request, PayrollLanguageLevel $language_level)
    {
        if ($request->ajax())
        {
            $language_level->delete();
            $request->session()->flash('message', ['type' => 'destroy']);
            return response()->json(['result' => true]);
        }
        return redirect()->route('payroll.language-levels.index');
    }
}
