<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetDisincorporation;
use Modules\Asset\Models\Asset;

use Modules\Asset\Models\AssetType;
use Modules\Asset\Models\AssetCategory;
use Modules\Asset\Models\AssetSubcategory;
use Modules\Asset\Models\AssetSpecificCategory;

/**
 * @class AssetDisincorporationController
 * @brief Controlador de Desincorporaciones de Bienes Institucionales
 * 
 * Clase que gestiona las Desincorporaciones de Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetDisincorporationController extends Controller
{
    use ValidatesRequests;

    /**
     * Muestra un listado de las Desincorporaciones de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        $assets = Asset::all();
        $asset_disincorporations = AssetDisincorporation::all();
        return view('asset::disincorporations.list', compact('assets','asset_disincorporations'));
    }

    /**
     * Muestra el formulario para registrar una nueva Desincorporación de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        $header = [
            'route' => 'asset.disincorporation.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal',
        ];

        $assets = Asset::template_choices();
        $types = AssetType::template_choices();
        $categories = AssetCategory::template_choices();
        $subcategories = AssetSubcategory::template_choices();
        $specific_categories = AssetSpecificCategory::template_choices();

        return view('asset::disincorporations.create', compact('header','assets','types','categories','subcategories','specific_categories'));
    }

     /**
     * Valida y Registra una nueva Desincorporación de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [

            'asset_type' => 'required',
            'asset_category' => 'required',
            'asset_subcategory' => 'required',
            'asset_specific_category' => 'required',
            'asset' => 'required',
            //'staff_ubication' => 'required',
            //'staff' => 'required',

        ]);
        $disincorporation = new AssetDisincorporation;

        $disincorporation->asset_id = $request->asset;
        $disincorporation->date = $request->date;
        $disincorporation->motive = $request->motive;
        $disincorporation->observation = $request->observation;

        $disincorporation->save();
        return redirect()->route('asset.disincorporation.index');
    }

    
    /**
     * Muestra el formulario para Desincorporar un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\Asset  $asset (Datos del Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function Asset_Disassign(Asset $asset)
    {
        $header = [
            'route' => 'asset.disincorporation.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal',
        ];

        $disincorporation = new AssetDisincorporation;
        $disincorporation->asset_id = $asset->id;
        $assets = Asset::template_choices(['id' => $asset->id]);
        $types = AssetType::template_choices();
        $categories = AssetCategory::template_choices();
        $subcategories = AssetSubcategory::template_choices();
        $specific_categories = AssetSpecificCategory::template_choices();

        return view('asset::disincorporations.create', compact('header','disincorporation','assets','types','categories','subcategories','specific_categories'));
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
