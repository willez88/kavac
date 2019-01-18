<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetRequestProrroga;
use Modules\Asset\Models\AssetRequest;

use Illuminate\Support\Facades\Auth;

class AssetRequestProrrogaController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => AssetRequestProrroga::all()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'date' => 'required',
            'request_id' => 'required'
        ]);
    
        $prorroga = new AssetRequestProrroga;
            $prorroga->delivery_date = $request->date;
            $prorroga->request_id = $request->request_id;
            $prorroga->state = 'Pendiente';
            $prorroga->user_id = Auth::id();
            $prorroga->save();
            

        return response()->json(['record' => $prorroga, 'message' => 'Success'], 200);
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('asset::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('asset::edit');
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

    public function vuePendingList()
    {
        return response()->json(['records' => AssetRequestProrroga::where('state','Pendiente')->get()], 200);
    }

    public function approved($id)
    {
        $request_prorroga = AssetRequestProrroga::find($id);
        $request_prorroga->state = 'Aprobado';

        $request = $request_prorroga->request;
        $request->delivery_date = $request_prorroga->delivery_date;
        $request->save();

        $request_prorroga->save();
        return response()->json(['records' => AssetRequestProrroga::where('state','Pendiente')->get()], 200);
    }
    public function rejected($id)
    {
        $request = AssetRequestProrroga::find($id);
        $request->state = 'Rechazado';
        $request->save();
        return response()->json(['records' => AssetRequestProrroga::where('state','Pendiente')->get()], 200);
    }
}
