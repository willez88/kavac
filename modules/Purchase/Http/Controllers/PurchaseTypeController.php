<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Purchase\Models\PurchaseType;

/**
 * @class PurchaseTypeController
 * @brief Controlador para gestionar los tipos de compras
 *
 * Clase que gestiona los tipos de compras
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PurchaseTypeController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(['records' => PurchaseType::with('purchaseProcess')->orderBy('id')->get()], 200);
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
            'name' => ['required', 'unique:purchase_types,name'],
            'purchase_processes_id' => ['required'],
        ],
            [ 'purchase_processes_id.required' => 'El campo proceso de compra es obligatorio.']
        );

        PurchaseType::create($request->all());
        return response()->json(['records' => PurchaseType::with('purchaseProcess')->orderBy('id')->get(),
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
            'name' => ['required', 'unique:purchase_types,name,' . $id],
            'purchase_processes_id' => ['required'],
        ], 
            [ 'purchase_processes_id.required' => 'El campo proceso de compra es obligatorio.']
        );

        $record                        = PurchaseType::find($id);
        $record->name                  = $request->name;
        $record->description           = $request->description;
        $record->purchase_processes_id = $request->purchase_processes_id;
        $record->save();
        return response()->json(['records' => PurchaseType::with('purchaseProcess')->orderBy('id')->get(),
            'message'=>'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return JsonResponse
     */
    public function destroy($id)
    {
        $type = PurchaseType::find($id);
        if ($type) {
            $type->->delete();
        }
        return response()->json(['records' => PurchaseType::with('purchaseProcess')->orderBy('id')->get(),
            'message'=>'Success'], 200);
    }
}
