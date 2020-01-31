<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Purchase\Models\PurchaseTypeHiring;

class PurchaseTypeHiringController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => PurchaseTypeHiring::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('purchase::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        if ($request->active) {
            $record_ant = PurchaseTypeHiring::where('type', $request->type)->where('active', true)->first();
            if ($record_ant) {
                $record_ant->active = false;
                $record_ant->save();
            }
        }
        PurchaseTypeHiring::create($request->all());

        return response()->json(['records' => PurchaseTypeHiring::all(),
            'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        // return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        // return view('purchase::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        if ($request->active) {
            $record_ant = PurchaseTypeHiring::where('type', $request->type)->where('active', true)->first();
            if ($record_ant) {
                $record_ant->active = false;
                $record_ant->save();
            }
        }

        $record         = PurchaseTypeHiring::find($id);
        $record->date   = $request->date;
        $record->active = $request->active;
        $record->type   = $request->type;
        $record->ut     = $request->ut;
        $record->save();
        return response()->json(['records' => PurchaseTypeHiring::all(),
            'message'=>'Success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        PurchaseTypeHiring::find($id)->delete();
        return response()->json(['records' => PurchaseTypeHiring::all(),
            'message'=>'Success'], 200);
    }
}
