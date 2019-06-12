<?php

namespace Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use App\Models\CodeSetting;
use App\Rules\CodeSetting as CodeSettingRule;
use Modules\Finance\Models\FinanceCheckBook;

/**
 * @class FinanceController
 * @brief Controlador principal del módulo de finanzas
 * 
 * Clase que gestiona el módulo de finanzas
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class FinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('finance::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('finance::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'checks_code' => [new CodeSettingRule]
        ]);

        list($prefix, $digits, $sufix) = CodeSetting::divideCode($request->checks_code);

        CodeSetting::updateOrCreate([
            'module' => 'finance',
            'table' => 'finance_check_books',
            'field' => 'code',
            'type' => null
        ], [
            'format_prefix' => $prefix,
            'format_digits' => $digits,
            'format_year' => $sufix,
            'model' => FinanceCheckBook::class,
        ]);

        $request->session()->flash('message', ['type' => 'store']);

        return redirect()->back();
    }

    /**
     * Show the specified resource.
     * @return \Illuminate\View\View
     */
    public function show()
    {
        return view('finance::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return \Illuminate\View\View
     */
    public function edit()
    {
        return view('finance::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    /**
     * Gestiona la configuración para los cheques a emitir
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\View\View
     */
    public function setting()
    {
        $checkCode = CodeSetting::where('model', FinanceCheckBook::class)->first() ?? '';
        return view('finance::settings', compact('checkCode'));
    }
}
