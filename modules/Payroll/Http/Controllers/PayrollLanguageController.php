<?php

namespace Modules\Payroll\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Payroll\Models\PayrollLanguage;

/**
 * @class PayrolllanguageController
 * @brief Controlador de idioma
 *
 * Clase que gestiona los idiomas
 *
 * @author William Páez <wpaez at cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class PayrollLanguageController extends Controller
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
        $this->middleware('permission:payroll.languages.list', ['only' => 'index']);
        $this->middleware('permission:payroll.languages.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:payroll.languages.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:payroll.languages.delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $languages = PayrollLanguage::all();
        return view('payroll::languages.index', compact('languages'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header = [
            'route' => 'languages.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::languages.create-edit', compact('header'));
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
            'acronym' => 'required|10'
        ]);
        $language = new PayrollLanguage;
        $language->name  = $request->name;
        $language->acronym  = $request->acronym;
        $language->save();
        $request->session()->flash('message', ['type' => 'store']);
        return redirect()->route('languages.index');
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
    public function edit(PayrollLanguage $language)
    {
        $header = [
            'route' => ['languages.update', $language], 'method' => 'PUT', 'role' => 'form', 'class' => 'form',
        ];
        return view('payroll::languages.create-edit', compact('language','header'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, PayrollLanguage $language)
    {
        $this->validate($request, [
            'name' => 'required|max:100',
            'acronym' => 'required|10',
        ]);
        $language->name  = $request->name;
        $language->acronym  = $request->acronym;
        $language->save();
        $request->session()->flash('message', ['type' => 'update']);
        return redirect()->route('languages.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Request $request, PayrollLanguage $language)
    {
        if ($request->ajax())
        {
            $language->delete();
            $request->session()->flash('message', ['type' => 'destroy']);
            return response()->json(['result' => true]);
        }
        return redirect()->route('languages.index');
    }
}
