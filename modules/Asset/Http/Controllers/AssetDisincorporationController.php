<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetDisincorporation;
use Modules\Asset\Models\AssetDisincorporationAsset;
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
    public function create(Request $request)
    {
        $header = [
            'route' => 'asset.disincorporation.store', 'method' => 'POST', 'role' => 'form', 'id' => 'form','class' => 'form-horizontal',
        ];

        $case = 5;
        $assets = Asset::AssetClasification($case,$request->type,$request->category,$request->subcategory,$request->specific_category)->get();
        $types = AssetType::template_choices();
        $categories = AssetCategory::template_choices();
        $subcategories = AssetSubcategory::template_choices();
        $specific_categories = AssetSpecificCategory::template_choices();
        $motive = AssetMotiveDisincorporation::template_choices();
        $type_search=1;

        return view('asset::disincorporations.create', compact('header','request','assets','types','categories','subcategories','specific_categories','motive','type_search'));
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

            //'ubication' => 'required',
            //'staff' => 'required',
            'motive_id' => 'required',
            'observation' => 'required'

        ]);
        $datos = explode(',',$request->ids);
        $cantidad = 0;

        $disincorporation = new AssetDisincorporation;

        $disincorporation->date = $request->date;
        $disincorporation->motive_id = $request->motive_id;
        $disincorporation->observation = $request->observation;

        $disincorporation->save();

        while ($cantidad < count($datos)) {
            $seleccionados = new AssetDisincorporationAsset;
            $asset = Asset::where('serial_inventario',trim($datos[$cantidad]))->first();
            //Validar Estatus del bien de acuerdo a motivo de la desincorporacion
            $asset->status_id = 7;
            $seleccionados->asset_id = $asset->id;
            $seleccionados->disincorporation_id = $disincorporation->id;

            $seleccionados->save();
            $asset->save();
            $cantidad++;

        }
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
            'route' => 'asset.disincorporation.store', 'method' => 'POST', 'role' => 'form', 'id' => 'form','class' => 'form-horizontal',
        ];

        $assets = Asset::whereNotIn('status_id',array(6,7,8,9))->get();;
        $types = AssetType::template_choices();
        $categories = AssetCategory::template_choices();
        $subcategories = AssetSubcategory::template_choices();
        $specific_categories = AssetSpecificCategory::template_choices();
        $motive = AssetMotiveDisincorporation::template_choices();
        $type_search=1;

        $data[0]= $asset->serial_inventario;
        $select = json_encode($data);

        return view('asset::disincorporations.create', compact('header','assets','types','categories','subcategories','specific_categories','motive','select','type_search'));
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
    public function edit(Request $request,AssetDisincorporation $disincorporation)
    {
        $header = [
            'route' => ['asset.disincorporation.update', $disincorporation], 'method' => 'PUT', 'role'=> 'form', 'id' => 'form', 'class' => 'form-horizontal',
        ];
        $case=6;
        $assets = Asset::AssetClasification($case,$request->type,$request->category,$request->subcategory,$request->specific_category)->get();
        $request = $disincorporation;
        $types = AssetType::template_choices();
        $categories = AssetCategory::template_choices();
        $subcategories = AssetSubcategory::template_choices();
        $specific_categories = AssetSpecificCategory::template_choices();
        $select = AssetDisincorporationAsset::where('disincorporation_id',$disincorporation->id)->get();
        $type_search =2;
        
        $data = [];
        $index=0;
        foreach ($select as $key) {            
            $asset = Asset::find($key->asset_id);
            $data[$index]= $asset->serial_inventario;
            $index++;
        }
        $select =json_encode($data);

        $motive = AssetMotiveDisincorporation::template_choices();

        return view('asset::disincorporations.create', compact('header','request','assets', 'types', 'categories', 'subcategories', 'specific_categories','motive','select','type_search'));
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

            //'ubication' => 'required',
            //'staff' => 'required',
            'motive_id' => 'required',
            'observation' => 'required'

        ]);

        $disincorporation->date = $request->date;
        $disincorporation->motive_id = $request->motive_id;
        $disincorporation->observation = $request->observation;

        $disincorporation->save();

        $datos = explode(' , ',$request->ids);
        $cantidad = 0;

        $seleccionados = AssetDisincorporationAsset::where('disincorporation_id',$disincorporation->id)->get();

        /* Recorro la vieja lista para verificar si hay elementos eliminados en la nueva lista */
        
        foreach ($seleccionados as $asset_disincorporation) {
            $old_asset = $asset_disincorporation->asset()->first();
            $serial = $old_asset->serial_inventario;
            $clave = in_array($serial, $datos);
            if ($clave == false){
                $old_asset->status_id = 10;
                $asset_disincorporation->delete();
                $old_asset->save();
            }
        }
        
        /* Recorro la nueva lista para verificar si hay nuevos elementos a ser insertados */
        while ($cantidad < count($datos)) {          
            $asset = Asset::where('serial_inventario',trim($datos[$cantidad]))->first();
            $new_asset = $seleccionados->where('asset_id',$asset->id)->first();
            if (is_null($new_asset)){
                $new_asset = new AssetDisincorporationAsset;
                $asset->status_id = 1;
                $new_asset->asset_id = $asset->id;
                $new_asset->disincorporation_id = $disincorporation->id;        
                $new_asset->save();
                $asset->save();
            }                
            $cantidad++;

        }
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
        return back()->with(['message' => ['type' => 'destroy']]);
    }

    /**
     * Vizualiza la Información de la Desincorporación de un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetDisincorporation $disincorporation (Datos de la Desincorporación de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function vueInfo($id){
        $asset_request = AssetDisincorporationAsset::where('disincorporation_id',$id)->with('asset')->get();

        return response()->json(['records' => $asset_request], 200);
    }

}
