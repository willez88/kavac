<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetDisincorporation;
use Modules\Asset\Models\AssetMotiveDisincorporation;
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
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.disincorporation.list', ['only' => 'index']);
        $this->middleware('permission:asset.disincorporation.create', ['only' => ['create', 'Asset_Disassign', 'store']]);
        $this->middleware('permission:asset.disincorporation.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:asset.disincorporation.delete', ['only' => 'destroy']);
    }
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
        $motive = AssetMotiveDisincorporation::template_choices();

        return view('asset::disincorporations.create', compact('header','assets','types','categories','subcategories','specific_categories','motive'));
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

            'type' => 'required',
            'category' => 'required',
            'subcategory' => 'required',
            'specific_category' => 'required',
            'asset' => 'required',
            //'ubication' => 'required',
            //'staff' => 'required',
            'motive' => 'required',
            'observation' => 'required'

        ]);
        $disincorporation = new AssetDisincorporation;

        $disincorporation->asset_id = $request->asset;
        $disincorporation->date = $request->date;
        $disincorporation->motive_id = $request->motive;
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
        $types = AssetType::template_choices(['id' => $asset->type_id]);
        $categories = AssetCategory::template_choices(['id' => $asset->category_id]);
        $subcategories = AssetSubcategory::template_choices(['id' => $asset->subcategory_id]);
        $specific_categories = AssetSpecificCategory::template_choices(['id' => $asset->specific_category_id]);
        $motive = AssetMotiveDisincorporation::template_choices();

        return view('asset::disincorporations.create', compact('header','disincorporation','assets','asset','types','categories','subcategories','specific_categories','motive'));
        }

    /**
     * Muestra los datos de las Desincorporaciones de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetDisincorporation  $disincorporation (Datos de la desincorporación de un Bien)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function show(AssetDisincorporation $disincorporation)
    {
        
    }

    /**
     * Muestra el formulario para actualizar la información de las Desincorporaciones de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetDisincorporation  $disincorporation (Datos de la Desincorporación de un Bien)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function edit(AssetDisincorporation $disincorporation)
    {
        $header = [
            'route' => ['asset.disincorporation.update', $disincorporation], 'method' => 'PUT', 'role'=> 'form', 'class' => 'form',
        ];
        
        $asset = $disincorporation->asset;
        $assets = Asset::template_choices(['id' => $asset->id]);
        $types = AssetType::template_choices(['id' => $asset->type_id]);
        $categories = AssetCategory::template_choices(['id' => $asset->category_id]);
        $subcategories = AssetSubcategory::template_choices(['id' => $asset->subcategory_id]);
        $specific_categories = AssetSpecificCategory::template_choices(['id' => $asset->specific_category_id]);
        $motive = AssetMotiveDisincorporation::template_choices();

        return view('asset::disincorporations.create', compact('header', 'disincorporation', 'assets', 'types', 'categories', 'subcategories', 'specific_categories','asset','motive'));
    }

    /**
     * Actualiza la información de las Desincorporaciones de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Asset\Models\AssetDisincorporation  $disincorporation (Datos de la Desincorporación de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, AssetDisincorporation $disincorporation)
    {
        $this->validate($request, [

            'type' => 'required',
            'category' => 'required',
            'subcategory' => 'required',
            'specific_category' => 'required',
            'asset' => 'required',
            //'ubication' => 'required',
            //'staff' => 'required',
            'motive' => 'required',
            'observation' => 'required'

        ]);

        $disincorporation->asset_id = $request->asset;
        $disincorporation->date = $request->date;
        $disincorporation->motive_id = $request->motive;
        $disincorporation->observation = $request->observation;

        $disincorporation->save();
        return redirect()->route('asset.disincorporation.index');
    }

    /**
     * Elimina una Asignación de un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetDisincorporation $disincorporation (Datos de la Desincorporación de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(AssetDisincorporation $disincorporation)
    {
        $disincorporation->delete();
        return back()->with('info', 'Fue eliminado exitosamente');
    }

    /**
     * Vizualiza la Información de la Desincorporación de un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetDisincorporation $disincorporation (Datos de la Desincorporación de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function info(AssetDisincorporation $disincorporation){

        $dato = AssetDisincorporation::findorfail($disincorporation->id);
        $this->data[] = [
            'id' => $dato->id,
            'type' => $dato->asset->type->name,
            'category' => $dato->asset->category->name,
            'subcategory' => $dato->asset->subcategory->name,
            'specific' => $dato->asset->specific->name,
            'description' => $dato->asset->getDescription(),
            'ubication' => $dato->asset->institution_id,
            'staff' => $dato->asset->staff_id,
            'date' => $dato->date,
            'motive' => $dato->motive->name,
            'observe' => $dato->observation
            
                
        ];

        return response()->json(['record' => $this->data[0]]);

    }
}
