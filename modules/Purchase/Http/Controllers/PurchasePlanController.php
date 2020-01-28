<?php

namespace Modules\Purchase\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Purchase\Models\PurchasePlan;
use Modules\Purchase\Models\PurchaseProcess;
use Modules\Purchase\Models\PurchaseType;

class PurchasePlanController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $record_list = PurchasePlan::with('purchaseProcess', 'purchaseType')->orderBy('id')->get();
        return view('purchase::purchase_plans.index', compact('record_list'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $purchase_process = template_choices('Modules\Purchase\Models\PurchaseProcess', 'name', [], true);

        $purchase_types = [];
        array_push($purchase_types, [
            'id'                    =>  '',
            'text'                  =>  'Seleccione...',
            'purchase_processes_id' =>  '',
        ]);

        foreach (PurchaseType::with('purchaseProcess')->orderBy('id')->get() as $record) {
            array_push($purchase_types, [
                'id'                    =>  $record->id,
                'text'                  =>  $record->name,
                'purchase_processes_id' =>  $record->purchase_processes_id,
            ]);
        }
        return view('purchase::purchase_plans.form', [
            'purchase_process' => json_encode($purchase_process),
            'purchase_types'    => json_encode($purchase_types)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'purchase_type_id'      => 'required|int',
            'purchase_processes_id' => 'required|int',
            'init_date'             => 'required|date',
            'end_date'              => 'required|date',
        ], [
            'purchase_type_id.required'      => 'El campo tipo de compra es obligatorio.',
            'purchase_type_id.int'           => 'El campo tipo de compra no tiene el formato adecuado.',
            'purchase_processes_id.required' => 'El campo proceso de compra es obligatorio.',
            'purchase_processes_id.int'      => 'El campo proceso de compra no tiene el formato adecuado.',
            'init_date.required'             => 'El campo fecha inical es obligatorio.',
            'init_date.date'                 => 'El campo fecha inicial no tiene el formato adecuado.',
            'end_date.required'              => 'El campo fecha inical es obligatorio.',
            'end_date.date'                  => 'El campo fecha de culminación no tiene el formato adecuado.',
        ]);

        PurchasePlan::create($request->all());
        return response()->json(['message'=>'success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('purchase::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit($id)
    {
        $record_edit = PurchasePlan::find($id);

        $purchase_process = template_choices('Modules\Purchase\Models\PurchaseProcess', 'name', [], true);

        $purchase_types = [];
        array_push($purchase_types, [
            'id'                    =>  '',
            'text'                  =>  'Seleccione...',
            'purchase_processes_id' =>  '',
        ]);

        foreach (PurchaseType::with('purchaseProcess')->orderBy('id')->get() as $record) {
            array_push($purchase_types, [
                'id'                    =>  $record->id,
                'text'                  =>  $record->name,
                'purchase_processes_id' =>  $record->purchase_processes_id,
            ]);
        }

        return view('purchase::purchase_plans.form', [
            'purchase_process' => json_encode($purchase_process),
            'purchase_types'    => json_encode($purchase_types),
            'record_edit'       => $record_edit,
        ]);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, $id)
    {
        $record                        = PurchasePlan::find($id);
        $record->init_date             = $request->init_date;
        $record->end_date              = $request->end_date;
        $record->purchase_processes_id = $request->purchase_processes_id;
        $record->purchase_type_id      = $request->purchase_type_id;
        $record->save();
        return response()->json(['message'=>'success'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy($id)
    {
        PurchasePlan::find($id)->delete();
        return response()->json(['message'=>'Success'], 200);
    }
}
