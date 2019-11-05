<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;

use Modules\Asset\Models\AssetRequestExtension;
use Modules\Asset\Models\AssetRequest;
use Modules\Asset\Rules\DateExtension;

/**
 * @class AssetRequestExtensionController
 * @brief Controlador de prorrogas de entrega en bienes institucionales solicitados
 *
 * Clase que gestiona las prorrogas de entrega solicitadas
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetRequestExtensionController extends Controller
{
    use ValidatesRequests;

    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => AssetRequestExtension::all()], 200);
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
            'asset_request_id' => ['required']
        ]);
        $asset_request = AssetRequest::find($request->asset_request_id);
        $this->validate($request, [
            'date' => [new DateExtension($asset_request->delivery_date, '2')],
        ]);
        
        $prorroga = new AssetRequestExtension;
        $prorroga->delivery_date = $request->date;
        $prorroga->asset_request_id = $request->asset_request_id;
        $prorroga->state = 'Pendiente';
        $prorroga->user_id = Auth::id();
        $prorroga->save();
            

        $request->session()->flash('message', ['type' => 'store']);
        return response()->json(['result' => true, 'redirect' => route('asset.request.index')], 200);
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
        return response()->json(
            ['records' => AssetRequestExtension::with('user')->where('state', 'Pendiente')->get()],
            200
        );
    }

    public function approved(Request $request, $id)
    {
        $request_prorroga = AssetRequestExtension::find($id);
        $request_prorroga->state = 'Aprobado';

        $asset_request = $request_prorroga->assetRequest;
        $asset_request->delivery_date = $request_prorroga->delivery_date;
        $asset_request->save();
        
        $request_prorroga->save();

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('asset.request.index')], 200);
    }

    public function rejected(Request $request, $id)
    {
        $asset_request = AssetRequestExtension::find($id);
        $asset_request->state = 'Rechazado';
        $asset_request->save();
        
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('asset.request.index')], 200);
    }
}
