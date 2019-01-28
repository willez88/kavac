<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\AssetAsignation;
use Modules\Asset\Models\AssetAsignationAsset;
use Modules\Asset\Models\Asset;
/*
 * use Modules\Payroll\Models\PayrollStaff
 */
use Modules\Asset\Models\AssetType;
use Modules\Asset\Models\AssetCategory;
use Modules\Asset\Models\AssetSubcategory;
use Modules\Asset\Models\AssetSpecificCategory;
use Modules\Asset\Models\AssetInventary;

/**
 * @class AssetAsignationController
 * @brief Controlador de Asignaciones de Bienes Institucionales
 * 
 * Clase que gestiona las Asignaciones de Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetAsignationController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.asignation.list', ['only' => 'index']);
        $this->middleware('permission:asset.asignation.create', ['only' => ['create', 'Asset_Assign', 'store']]);
        $this->middleware('permission:asset.asignation.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:asset.asignation.delete', ['only' => 'destroy']);
    }
    use ValidatesRequests;

    /**
     * Muestra un listado de las Asignaciones de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        $assets = Asset::all();
        $asset_asignations = AssetAsignation::all();
        return view('asset::asignations.list', compact('assets','asset_asignations'));
    }

    /**
     * Muestra el formulario para registrar una nueva Asignación de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create(Request $request)
    {
        $header = [
            'route' => 'asset.asignation.store', 'method' => 'POST', 'role' => 'form', 'id' => 'form','class' => 'form-horizontal',
        ];
        $case=1;//New Asignation
        $assets = Asset::AssetClasification($case,$request->type,$request->category,$request->subcategory,$request->specific_category)->get();
        $types = AssetType::template_choices();
        $categories = AssetCategory::template_choices();
        $subcategories = AssetSubcategory::template_choices();
        $specific_categories = AssetSpecificCategory::template_choices();

        return view('asset::asignations.create', compact('header','assets','types','categories','subcategories','specific_categories','request'));
    }

    /**
     * Muestra el formulario para registrar una nueva Asignación de un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
      * @param  \Modules\Asset\Models\Asset  $asset (Datos del Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function Asset_Assign(Asset $asset)
    {
        $header = [
            'route' => 'asset.asignation.store', 'method' => 'POST', 'role' => 'form', 'id' => 'form','class' => 'form-horizontal',
        ];

        
        $assets = Asset::where('status_id', 10)->get();
        $types = AssetType::template_choices();
        $categories = AssetCategory::template_choices();
        $subcategories = AssetSubcategory::template_choices();
        $specific_categories = AssetSpecificCategory::template_choices();

        $data[0]= $asset->serial_inventario;
        $select = json_encode($data);


        return view('asset::asignations.create', compact('header','asignation','assets','types','categories','subcategories','specific_categories','select'));
        }

    /**
     * Valida y Registra una nueva Asignación de Bienes Institucionales
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

        ]);
        $datos = explode(',',$request->ids);
        $cantidad = 0;

        $asignation = new AssetAsignation;

        $asignation->staff_id = $request->staff;
        $asignation->save();

        while ($cantidad < count($datos)) {
            $seleccionados = new AssetAsignationAsset;
            $asset = Asset::where('serial_inventario',trim($datos[$cantidad]))->first();
            $asset->status_id = 1;
            $seleccionados->asset_id = $asset->id;
            $seleccionados->asignation_id = $asignation->id;

            $seleccionados->save();
            $asset->save();
            $cantidad++;

        }
        return redirect()->route('asset.asignation.index');

    }

    /**
     * Muestra los datos de las Asignaciones de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetAsignation  $asignation (Datos de la asignacion de un Bien)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function show(AssetAsignation $asignation)
    {
        
    }

    /**
     * Muestra el formulario para actualizar la información de las Asignaciones de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetAsignation  $asignation (Datos de la Asignación de un Bien)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function edit(Request $request,AssetAsignation $asignation)
    {
        $header = [
            'route' => ['asset.asignation.update', $asignation], 'method' => 'PUT', 'role'=> 'form', 'id' => 'form','class' => 'form-horizontal',
        ];
        
        $case=2; //Edit Asignation
        $assets = Asset::AssetClasification($case,$request->type,$request->category,$request->subcategory,$request->specific_category)->get();
        $types = AssetType::template_choices();
        $categories = AssetCategory::template_choices();
        $subcategories = AssetSubcategory::template_choices();
        $specific_categories = AssetSpecificCategory::template_choices();
        $select = AssetAsignationAsset::where('asignation_id',$asignation->id)->get();
        $data = [];
        $index=0;
        foreach ($select as $key) {            
            $asset = Asset::find($key->asset_id);
            $data[$index]= $asset->serial_inventario;
            $index++;
        }
        $select =json_encode($data);

        return view('asset::asignations.create', compact('header', 'asignation', 'assets','types','categories','subcategories','specific_categories','select'));
    }

    /**
     * Actualiza la información de las Asignaciones de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Asset\Models\AssetAsignation  $asignation (Datos de la Asignación de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, AssetAsignation $asignation)
    {
        $this->validate($request, [

            //'ubication' => 'required',
            //'staff' => 'required',

        ]);

        $asignation->staff_id = $request->staff;
        $asignation->save();

        $datos = explode(' , ',$request->ids);
        $cantidad = 0;

        $seleccionados = AssetAsignationAsset::where('asignation_id',$asignation->id)->get();

        /* Recorro la vieja lista para verificar si hay elementos eliminados en la nueva lista */
        
        foreach ($seleccionados as $asset_asignation) {
            $old_asset = $asset_asignation->asset()->first();
            $serial = $old_asset->serial_inventario;
            $clave = in_array($serial, $datos);
            if ($clave == false){
                $old_asset->status_id = 10;
                $asset_asignation->delete();
                $old_asset->save();
            }
        }
        
        /* Recorro la nueva lista para verificar si hay nuevos elementos a ser insertados */

        while ($cantidad < count($datos)) {          
            $asset = Asset::where('serial_inventario',trim($datos[$cantidad]))->first();
            $new_asset = $seleccionados->where('asset_id',$asset->id)->first();
            if (is_null($new_asset)){
                $new_asset = new AssetAsignationAsset;
                $asset->status_id = 1;
                $new_asset->asset_id = $asset->id;
                $new_asset->asignation_id = $asignation->id;        
                $new_asset->save();
                $asset->save();
            }                
            $cantidad++;

        }
        return redirect()->route('asset.asignation.index');
    }

    /**
     * Elimina una Asignación de un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetAsignation $asignation (Datos de la Asignación de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(AssetAsignation $asignation)
    {
        
        return back()->with('info', 'Fue eliminado exitosamente');

    }

    /**
     * Vizualizar Información de la Asignación de un Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\AssetAsignation $asignation (Datos de la Asignación de un Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    
    public function vueInfo($id){
        $asset_request = AssetAsignationAsset::where('asignation_id',$id)->with('asset')->get();

        return response()->json(['records' => $asset_request], 200);
    }
}
