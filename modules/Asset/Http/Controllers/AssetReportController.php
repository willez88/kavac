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
    
    public function index(Request $request, $tipo){
        $assets= Asset::nameclasification($request->type,$request->category,$request->subcategory,$request->specific_category)->get();

        $types = AssetType::template_choices();
        $categories = AssetCategory::template_choices();
        $subcategories = AssetSubcategory::template_choices();
        $specific_categories = AssetSpecificCategory::template_choices();

        if ($tipo ==1){
            return view('asset::reports.asset_general', compact('assets','types','categories','subcategories','specific_categories'));
        }
        elseif ($tipo ==2) {
            return view('asset::reports.asset_clasification', compact('assets','types','categories','subcategories','specific_categories'));
        }
    }
}
