<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Asset\Models\AssetClasification;
use Modules\Asset\Models\Type;
use Modules\Asset\Models\Category;
use Modules\Asset\Models\Subcategory;
use Modules\Asset\Models\SpecificCategory;
use Auth;

class AssetClasificationController extends Controller
{
    
    use ValidatesRequests;
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        $records = AssetClasification::all();
        return view('asset::clasification.list', compact('records'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $header_asset = [
            'route'  => 'asset.clasification.store', 
            'method' => 'POST', 
            'role' => 'form', 
            'class' => 'form-horizontal',
        ];
        $asset_type = Type::template_choices();
        $categories = Category::template_choices();
        $subcategories = Subcategory::template_choices();
        $specifics = SpecificCategory::template_choices();
        return view('asset::clasification.create', compact('header_asset','asset_type','categories','subcategories','specifics'));
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


            'Asset_type' => 'required'
            
        ]);
       $category = new Category;
        if ( $request->Asset_category == '0'){

            $category->asset_type_id = $request->Asset_type;
            $category->code = $request->Asset_type;
            $category->name = $request->New_category;
            $category->save();
            return redirect()->route('asset.clasification.index');

        }else
        {
            return redirect()->route('asset.clasification.index');
        }

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
}
