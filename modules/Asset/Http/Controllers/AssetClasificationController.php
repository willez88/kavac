<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Asset\Models\AssetClasification;
use Modules\Asset\Models\AssetType;
use Modules\Asset\Models\AssetCategory;
use Modules\Asset\Models\AssetSubcategory;
use Modules\Asset\Models\AssetSpecificCategory;

class AssetClasificationController extends Controller
{
    
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return response()->json(['records' => AssetSpecificCategory::with(['subcategory' => 

            function($query){
                $query->with(['category' => 
                function($query){
                    $query->with('type');
                }]);
            }]
        )->get()], 200);
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {   
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'type_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'code' => 'required',
            'name' => 'required',
        ]);
        if ($request->type_id === '-1')
            $this->validate($request,[
                'type.name' => 'required',
            ]);
        if ($request->category_id === '-1')
            $this->validate($request,[
                'category.code' => 'required',
                'category.name' => 'required',
            ]);
        if ($request->subcategory_id === '-1')
            $this->validate($request,[
                'subcategory.code' => 'required',
                'subcategory.name' => 'required',
            ]);

        if($request->type_id === '-1'){
            $type = AssetType::create([
                'name' => $request->input('name'),
            ]);
        }

        if($request->category_id === '-1'){
            $category = AssetCategory::create([
                'code' => $request->input('category.code'),
                'name' => $request->input('category.name'),
                'asset_type_id' => $type->id,
            ]);
        }
        if($request->subcategory_id === '-1'){
            $subcategory = AssetSubcategory::create([
                'code' => $request->input('subcategory.code'),
                'name' => $request->input('subcategory.name'),
                'asset_category_id' => $category->id,
            ]);
        }
        $specific = AssetSpecificCategory::create([
            'code' => $request->input('code'),
            'name' => $request->input('name'),
            'asset_subcategory_id' => ($request->subcategory_id === '-1')?$subcategory->id:$request->subcategory_id,
        ]);

        return response()->json(['records' => $specific, 'message' => 'Success'],200);
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
        //
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, AssetSpecificCategory $specific)
    {
        $this->validate($request,[
            'type_id' => 'required',
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'code' => 'required',
            'name' => 'required',
        ]);
        if ($request->type_id === '-1')
            $this->validate($request,[
                'type.name' => 'required',
            ]);
        if ($request->category_id === '-1')
            $this->validate($request,[
                'category.code' => 'required',
                'category.name' => 'required',
            ]);
        if ($request->subcategory_id === '-1')
            $this->validate($request,[
                'subcategory.code' => 'required',
                'subcategory.name' => 'required',
            ]);

        $specific = AssetSpecificCategory::find($request->id);
        
        $specific->name = $request->input('name');
        $specific->code = $request->input('code');
        $specific->asset_subcategory_id = $request->input('subcategory_id');

        $specific->save();

        return response()->json(['message' => 'Registro actualizado correctamente'], 200);

    }

    /**
     * Elimina la Categoria Especifica de un Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\Assetategory  $specific_category (Datos de la categoria especifica)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy($id)
    {
        $specific = AssetSpecificCategory::find($id);
        $specific->delete();
        return response()->json(['record' => $specific, 'message' => 'Success'], 200);
    }
}
