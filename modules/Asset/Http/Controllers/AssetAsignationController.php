<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetAsignation;
use Modules\Asset\Models\Asset;
use App\Models\Institution;
use App\Models\InstitutionSector;


use Auth;

class AssetAsignationController extends Controller
{
    
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $asset_asignations = AssetAsignation::all();
        return view('asset::asignation.index', compact('asset_asignations'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create(AssetAsignation $asignation)
    {
        $header_asset = [
            'route' => ['asset.asignation.store', $asignation], 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal',
        ];
        $institutions = Institution::template_choices();
        $sector_institutions = InstitutionSector::template_choices();
        return view('asset::asignation.create', compact('header_asset', 'asignation','institutions'));
    }
    

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
         $this->validate($request, [
            
/*
            'institution_id'  => 'required',
            'dependencia_id' => 'required',
            'staff_id' => 'required'
*/
        ]);
        $asignation = new AssetAsignation;

        $asignation->asset_id = '1';
        $asignation->staff_id = '1';
       
        $asignation->save();
        return redirect()->route('asset.asignation.index');
        
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
    public function edit(AssetAsignation $asignation)
    {
        $header_asset = [
            'route' => ['asset.asignation.update', $asignation], 'method' => 'PUT', 'role'=> 'form', 'class' => 'form',
        ];
        return view('asset::asignation.create', compact('asignation','header_asset'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, AssetAsignation $asignation)
    {
        $this->validate($request, [
            
            //Validar los campos del formulario

/*
            'institution_id'  => 'required',
            'dependencia_id' => 'required',
            'staff_id' => 'required',
*/
        ]);
        

        $asignation->staff_id = $request->staff_id;
       
        $asignation->save();
        return redirect()->route('asset.asignation.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(AssetAsignation $asignation)
    {
        $asignation->delete();
        return back()->with('info', 'Fue eliminado exitosamente');
    }
}
