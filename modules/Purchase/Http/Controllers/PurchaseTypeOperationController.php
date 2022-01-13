<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Purchase\Models\PurchaseTypeOperation;

/**
 * @class PurchaseTypeController
 * @brief Controlador para gestionar los tipos de operaciones
 *
 * Clase que gestiona los tipos de operaciones
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PurchaseTypeOperationController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => PurchaseTypeOperation::orderBy('id')->get()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('purchase::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
        ], [
            'name.required' => 'El campo nombre es obligatorio.',
        ]);

        PurchaseTypeOperation::create($request->all());
        return response()->json(['records' => PurchaseTypeOperation::orderBy('id')->get(),
            'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Renderable
     */
    public function show()
    {
        return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Renderable
     */
    public function edit()
    {
        return view('purchase::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'        => 'required',
        ], [
            'name.required'        => 'El campo nombre es obligatorio.',
        ]);

        $record                        = PurchaseTypeOperation::find($id);
        $record->name                  = $request->name;
        $record->description           = $request->description;
        $record->save();
        return response()->json(['records' => PurchaseTypeOperation::orderBy('id')->get(),
            'message'=>'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy($id)
    {
        PurchaseTypeOperation::find($id)->delete();
        return response()->json(['records' => PurchaseTypeOperation::orderBy('id')->get(),
            'message'=>'Success'], 200);
    }

    public function getRecords()
    {
        $records = template_choices('Modules\Purchase\Models\PurchaseTypeOperation', 'name', [], true);
        return response()->json(['records' => $records], 200);
    }
}
