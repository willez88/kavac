<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\Asset\Models\Asset;
use Modules\Asset\Models\AssetType;
use Modules\Asset\Models\AssetCategory;
use Modules\Asset\Models\AssetSubcategory;
use Modules\Asset\Models\AssetSpecificCategory;

class AssetReportController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.report.create', ['only' => 'create']);
    }
    public function create($tipo,Request $request){
        $request = ($request) ? $request:NULL;

        if ($tipo ==1){
            if (is_null($request)){
                $assets = Asset::all();
            }
            else{
                $assets= Asset::dateclasification($request->start_date,$request->end_date)->get();    
            }
            return view('asset::reports.asset_general', compact('assets'));
        }

        elseif ($tipo == 2) {
            if (is_null($request)){
                $assets = Asset::all();
            }
            else{
                $assets= Asset::codeclasification($request->type,$request->category,$request->subcategory,$request->specific_category)->get();
            }
            $types = AssetType::template_choices();
            $categories = AssetCategory::template_choices();
            $subcategories = AssetSubcategory::template_choices();
            $specific_categories = AssetSpecificCategory::template_choices();
            
            return view('asset::reports.asset_clasification', compact('assets','types','categories','subcategories','specific_categories'));
        }

        
        
    }
}
