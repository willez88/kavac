<?php

namespace Modules\Asset\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Modules\Asset\Models\Asset;
use Modules\Asset\Models\AssetType;
use Modules\Asset\Models\AssetCategory;
use Modules\Asset\Models\AssetSubcategory;
use Modules\Asset\Models\AssetSpecificCategory;

use Modules\Asset\Models\AssetPurchase;
use Modules\Asset\Models\AssetCondition;
use Modules\Asset\Models\AssetStatus;
use Modules\Asset\Models\AssetUse;
use App\Models\Department;

/**
 * @class AssetController
 * @brief Controlador de Bienes Institucionales
 * 
 * Clase que gestiona los Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetController extends Controller
{
    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:asset.list', ['only' => 'index']);
        $this->middleware('permission:asset.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:asset.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:asset.delete', ['only' => 'destroy']);
    }
    use ValidatesRequests;

    /**
     * Muestra un listado de los Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        $assets = Asset::all();
        return view('asset::Register.list', compact('assets'));
    }

    /**
     * Muestra el formulario para registrar un nuevo Bien Institucional
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        $header = [
            'route' => 'asset.store', 'method' => 'POST', 'role' => 'form', 'class' => 'form-horizontal',
        ];

        $types = AssetType::template_choices();
        $categories = AssetCategory::template_choices();
        $subcategories = AssetSubcategory::template_choices();
        $specific_categories = AssetSpecificCategory::template_choices();

        $departments = Department::all();
        $purchases = AssetPurchase::template_choices();
        $conditions = AssetCondition::template_choices();
        $status = AssetStatus::template_choices();
        $uses =AssetUse::template_choices();

        return view('asset::Register.create', compact('header','types','categories','subcategories','specific_categories', 'purchases', 'conditions','status','uses'));
    }

    /**
     * Valida y Registra un nuevo Bien Institucional
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
            //'department' => 'required',
            //'proveedor' => 'required',
            'purchase' => 'required',
            'purchase_year' => 'required',
            'status' => 'required|max:50',
            'condition' => 'required|max:50',
            'value' => 'required',

        ]);
        if ($request->type == 1){
            $this->validate($request,[
                'serial' => 'required|max:50',
                'marca'  => 'required|max:50',
                'model' => 'required|max:50',

            ]);
        }
        if ($request->type == 2){
            $this->validate($request,[
                'use' => 'required|max:50',
                'quantity'  => 'required|max:50',

            ]);
        }

        $asset = new Asset;
        /*
         * $asset->orden_compra = $request->orden_compra; 
        **/
        $asset->disposicion = "01-Activo";    
        $asset->type_id = $request->type;
        $asset->category_id = $request->category;
        $asset->subcategory_id = $request->subcategory;
        $asset->specific_category_id = $request->specific_category;
        $asset->institution_id = $request->department;
        $asset->proveedor_id = $request->proveedor;
        $asset->condition_id = $request->condition;
        $asset->purchase_id = $request->purchase;
        $asset->purchase_year = $request->purchase_year;
        $asset->status_id = $request->status;
        $asset->serial = $request->serial;
        $asset->marca = $request->marca;
        $asset->model = $request->model;
        $asset->serial_inventario = $asset->getCode();
        $asset->value = $request->value;
        $asset->use_id = $request->use;
        $asset->quantity = $request->quantity;

        $asset->save();
        return redirect()->route('asset.index');
    }

    /**
     * Muestra los datos de Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\Asset  $asset (Datos del bien)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function show(Asset $asset)
    {
        
    }

    /**
     * Muestra el formulario para actualizar la información de los Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\Asset  $asset (Datos del Bien)
     * @return \Illuminate\Http\Response (Objeto con los datos a mostrar)
     */
    public function edit(Asset $asset)
    {
        $header = [
            'route' => ['asset.update', $asset], 'method' => 'PUT', 'role'=> 'form', 'class' => 'form',
        ];
        $types = AssetType::template_choices();
        $categories = AssetCategory::template_choices();
        $subcategories = AssetSubcategory::template_choices();
        $specific_categories = AssetSpecificCategory::template_choices();

        $departments = Department::all();
        $purchases = AssetPurchase::template_choices();
        $conditions = AssetCondition::template_choices();
        $status = AssetStatus::template_choices();
        $uses = AssetUse::template_choices();

        return view('asset::Register.create', compact('header','asset','types','categories','subcategories','specific_categories', 'purchases', 'conditions','status','uses'));
    }

    /**
     * Actualiza la información de los Bienes Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Asset\Models\Asset  $asset (Datos del Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, Asset $asset)
    {
        $this->validate($request, [


            'type' => 'required',
            'category' => 'required',
            'subcategory' => 'required',
            'specific_category' => 'required',
            //'department' => 'required',
            //'proveedor' => 'required',
            'purchase' => 'required',
            'purchase_year' => 'required',
            'status' => 'required|max:50',
            'condition' => 'required|max:50',
            'value' => 'required',

        ]);
        if ($request->type == 1){
            $this->validate($request,[
                'serial' => 'required|max:50',
                'marca'  => 'required|max:50',
                'model' => 'required|max:50',

            ]);
        }
        if ($request->type == 2){
            $this->validate($request,[
                'use' => 'required|max:50',
                'quantity'  => 'required|max:50',

            ]);
        }

        /*
         * $asset->orden_compra = $request->orden_compra; 
        **/
        $asset->disposicion = "01-Activo";    
        $asset->type_id = $request->type;
        $asset->category_id = $request->category;
        $asset->subcategory_id = $request->subcategory;
        $asset->specific_category_id = $request->specific_category;
        $asset->institution_id = $request->department;
        $asset->proveedor_id = $request->proveedor;
        $asset->condition_id = $request->condition;
        $asset->purchase_id = $request->purchase;
        $asset->purchase_year = $request->purchase_year;
        $asset->status_id = $request->status;
        $asset->serial = $request->serial;
        $asset->marca = $request->marca;
        $asset->model = $request->model;
        $asset->serial_inventario = $asset->getCode();
        $asset->value = $request->value;
        $asset->use_id = $request->use;
        $asset->quantity = $request->quantity;
        $asset->save();
        return redirect()->route('asset.index');
    }

    /**
     * Elimina un Bien Institucionales
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @param  \Modules\Asset\Models\Asset $asset (Datos del Bien)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return back()->with('info', 'Fue eliminado exitosamente');
    }
}
