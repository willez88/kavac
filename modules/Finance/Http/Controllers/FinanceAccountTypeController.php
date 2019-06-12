<?php

namespace Modules\Finance\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Finance\Models\FinanceAccountType;

/**
 * @class FinanceAccountTypeController
 * @brief Controlador para los tipos de cuenta bancaria
 * 
 * Clase que gestiona los tipos de cuenta bancaria
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class FinanceAccountTypeController extends Controller
{
    use ValidatesRequests;

    /** @var array Lista de elementos a mostrar */
    protected $data = [];

    /**
     * Método constructor de la clase
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     */
    public function __construct() {
        $this->data[0] = [
            'id' => '',
            'text' => 'Seleccione...'
        ];
    }

    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => FinanceAccountType::all()], 200);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:100|unique:finance_account_types,name',
        ]);

        $financeAccountType = FinanceAccountType::create([
            'name' => $request->name,
        ]);

        return response()->json(['record' => $financeAccountType, 'message' => 'Success'], 200);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        /** @var object Datos del tipo de cuenta bancaria */
        $financeAccountType = FinanceAccountType::find($id);
        
        $this->validate($request, [
            'name' => 'required|max:100|unique:finance_account_types,name,' . $financeAccountType->id,
        ]);
 
        $financeAccountType->name = $request->name;
        $financeAccountType->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        /** @var object Datos del tipo de cuenta bancaria */
        $financeAccountType = FinanceAccountType::find($id);
        $financeAccountType->delete();
        return response()->json(['record' => $financeAccountType, 'message' => 'Success'], 200);
    }

    /**
     * Obtiene los tipos de cuenta bancaria
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Http\JsonResponse Devuelve un JSON con los datos de los tipos de cuenta bancaria
     */
    public function getAccountTypes()
    {
        foreach (FinanceAccountType::all() as $account_type) {
            $this->data[] = [
                'id' => $account_type->id,
                'text' => $account_type->name
            ];
        }

        return response()->json($this->data);
    }
}
