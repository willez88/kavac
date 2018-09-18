<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\Asset;
use Modules\Asset\Models\Type;
use Modules\Asset\Models\Category;
use Modules\Asset\Models\Subcategory;
use Modules\Asset\Models\SpecificCategory;

class AssetController extends Controller
{

    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $assets = Asset::all();
        return view('asset::assets.index', compact('assets'));
    }

    
    /**
     * Show the form for creating a new resource.
     * @return Response
     */

    public function create()
    {
        $header_asset = [
            'route' => 'asset.assets.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal',
        ];
        $asset_type = Type::template_choices();
        $categories = Category::template_choices();
        $subcategories = Subcategory::template_choices();
        $specifics = SpecificCategory::template_choices();
        return view('asset::assets.create', compact('header_asset','asset_type','categories','subcategories','specifics'));
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            
            //Validar los campos del formulario


            'asset_type_id' => 'required',
            'marca'  => 'required|max:50',
            'modelo' => 'required|max:50'

        ]);
        $asset = new Asset;
        $asset->type_id = $request->asset_type_id;
        $asset->category_id = $request->category_id;
        $asset->subcategory_id = $request->subcategory_id;
        $asset->specific_category_id = $request->specific_id;
        $asset->institucion_id = $request->institucion_id;
        $asset->proveedor_id = $request->proveedor_id;
        $asset->condicion = $request->condition_id;
        $asset->purchase_id = $request->purchase_id;
        $asset->status = $request->status_id;
        $asset->purchase_year = $request->purchase_year;
        $asset->serial = $request->serial;
        $asset->marca = $request->marca;
        $asset->modelo = $request->modelo;
        $asset->value = $request->value;
        $asset->save();
        return redirect()->route('asset.index');
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
    public function edit(Asset $asset)
    {
        $header_asset = [
            'route' => ['asset.assets.update', $asset], 'method' => 'PUT', 'role'=> 'form', 'class' => 'form',
        ];
        $asset_type = Type::template_choices();
        $categories = Category::template_choices();
        $subcategories = Subcategory::template_choices();
        $specifics = SpecificCategory::template_choices();

        return view('asset::assets.create', compact('asset','header_asset','asset_type','categories','subcategories','specifics'));
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request, Asset $asset)
    {
        $this->validate($request, [
            //Validar los campos del formulario


            'marca'  => 'required|max:50',
            'modelo' => 'required|max:50'

        ]);
        $asset->type_id = $request->asset_type_id;
        $asset->category_id = $request->category_id;
        $asset->subcategory_id = $request->subcategory_id;
        $asset->specific_category_id = $request->specific_id;
        $asset->institucion_id = $request->institucion_id;
        $asset->proveedor_id = $request->proveedor_id;
        $asset->condicion = $request->condition_id;
        $asset->purchase_id = $request->purchase_id;
        $asset->status = $request->status_id;
        $asset->purchase_year = $request->purchase_year;
        $asset->serial = $request->serial;
        $asset->marca = $request->marca;
        $asset->modelo = $request->modelo;
        $asset->value = $request->value;
        $asset->save();
        return redirect()->route('asset.assets.index');
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return back()->with('info', 'Fue eliminado exitosamente');
    }
}
