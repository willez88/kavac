<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Warehouse\Models\WarehouseClose;
use Illuminate\Support\Facades\Auth;

class WarehouseCloseController extends Controller
{
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => WarehouseClose::with('start_user','end_user','warehouse')->get()], 200);
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date_init' => 'required',
            'observation' => 'required',
            'warehouse_id' => 'required',
        ]);

        $close = WarehouseClose::create([
            'date_init' => $request->input('date_init'),
            'date_end' => $request->input('date_end'),
            'observation' => $request->input('observation'),
            'warehouse_id' => $request->input('warehouse_id'),
            'user_init' => Auth::id(),            
        ]);
        if(!is_null($request->date_end)){
            $close->user_end =Auth::id();
            $close->save();
        }
        return response()->json(['record' => $close, 'message' => 'Success'], 200);
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request,WarehouseClose $close)
    {
        $this->validate($request, [
            'date_init' => 'required',
            'observation' => 'required',
            'warehouse_id' => 'required',
        ]);

        if($close->user_init == Auth::id())
        {
            $close->date_init = $request->input('date_init');
            $close->observation = $request->input('observation');
            $close->warehouse_id = $request->input('warehouse_id');
            if($close->user_end == $close->user_init)
                $close->date_end = $request->input('date_end');
        }
        else if(($close->user_end == Auth::id())||is_null($close->user_end))
        {
            $close->observation = $request->input('observation');
            $close->date_end = $request->input('date_end');
        }
        else
            return response()->json(['message' => 'No dispone los permisos'], 200);
        
        $close->save();
 
        return response()->json(['message' => 'Registro actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(WarehouseClose $close)
    {
        $close->delete();
        return response()->json(['record' => $close, 'message' => 'Success'], 200);
    }

    public function endClose($id)
    {
        $close = WarehouseClose::find($id);
        $close->date_end = now();
        $close->user_end = Auth::id();
        $close->save();
        return response()->json(['records' => WarehouseClose::with('start_user','end_user','warehouse')->get()], 200);
    }
}
