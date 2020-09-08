<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;

use Modules\Purchase\Models\PurchaseType;

class PurchaseTypeController extends Controller
{
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
        PurchaseType::find($id)->delete();
        return response()->json(['records' => PurchaseType::with('purchaseProcess')->orderBy('id')->get(),
            'message'=>'Success'], 200);
    }
}
