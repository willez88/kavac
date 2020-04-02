<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CodeSetting;

use Modules\Warehouse\Models\WarehouseInventoryProductMovement;
use Modules\Warehouse\Models\WarehouseInstitutionWarehouse;
use Modules\Warehouse\Models\WarehouseInventoryProduct;
use Modules\Warehouse\Models\WarehouseProductAttribute;
use Modules\Warehouse\Models\WarehouseProductValue;
use Modules\Warehouse\Models\WarehouseMovement;

/**
 * @class WarehouseReceptionController
 * @brief Controlador de recepciones de almacén
 *
 * Clase que gestiona las recepciones de los productos al almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseReceptionController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     */
    public function __construct()
    {

        /** Establece permisos de acceso para cada método del controlador */
        $this->middleware('permission:warehouse.movement.list', ['only' => 'index']);
        $this->middleware('permission:warehouse.movement.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:warehouse.movement.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:warehouse.movement.delete', ['only' => 'destroy']);
    }

    /**
     * Muestra un listado de las Recepciones o Ingresos de Almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return view('warehouse::receptions.list');
    }

    /**
     * Muestra el formulario para registrar un nuevo Ingreso de Almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        return view('warehouse::receptions.create');
    }

    /**
     * Valida y Registra un nuevo Ingreso de Almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'warehouse_inventory_products' => ['required'],
            'warehouse_id' => ['required'],
            'institution_id' => ['required'],

        ]);
        
        $codeSetting = CodeSetting::where('table', 'warehouse_movements')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('warehouse.setting.index')], 200);
        }

        $code  = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );
        $codeSetting = CodeSetting::where('table', 'warehouse_inventory_products')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('warehouse.setting.index')], 200);
        }

        $tam = count($request->warehouse_inventory_products);
        $i=0;
        for ($i=0; $i < $tam; $i++) {
            $attributes = $request->warehouse_inventory_products[$i]['warehouse_product_attributes'];
            $att = count($attributes);
            $j=0;
            $this->validate($request, [
                'warehouse_inventory_products.'.$i.'.warehouse_product_id' => ['required'],
                'warehouse_inventory_products.'.$i.'.quantity' => ['required'],
                'warehouse_inventory_products.'.$i.'.currency_id' => ['required'],
                'warehouse_inventory_products.'.$i.'.unit_value' => ['required'],
                
            ]);
            /*
             * Hacer validación mas detallada (ej: diferenciar tipo de dato en atributos)
             */
            for ($j=0; $j < $att; $j++) {
                $this->validate($request, [
                    'warehouse_inventory_products.'.$i.'.warehouse_product_attributes.'.$j.'.name' => ['required'],
                    'warehouse_inventory_products.'.$i.'.warehouse_product_attributes.'.$j.'.value' => ['required'],
                ]);
            }
        }


        /*********************************************************/
    
        $inst_ware = WarehouseInstitutionWarehouse::where('warehouse_id', $request->warehouse_id)
            ->where('institution_id', $request->institution_id)->first();

        DB::transaction(function () use ($request, $inst_ware, $code) {
            $movement = WarehouseMovement::create([
                'code' => $code,
                'type' => 'C',
                'state' => 'Pendiente',
                'description' => 'Registro manual de productos en el inventario del almacén',
                'warehouse_institution_warehouse_end_id' => $inst_ware->id,
                'user_id' => Auth::id(),
            ]);
            $equal = null;
                
            foreach ($request->warehouse_inventory_products as $product) {
                $product_id = $product['warehouse_product_id'];
                $currency = $product['currency_id'];
                $quantity = $product['quantity'];
                $value = $product['unit_value'];

                /** Se busca en el inventario por producto y unidad si existe un registro previo */

                $inventory = WarehouseInventoryProduct::where('warehouse_product_id', $product_id)
                    ->where('warehouse_institution_warehouse_id', $inst_ware->id)
                    ->where('unit_value', $value)->get();

                /** Si existe un registro previo se verifican los atributos del nuevo ingreso */
                if (count($inventory) > 0) {
                    foreach ($inventory as $product_inventory) {
                        /** @var boolean $equal Define si los atributos coinciden con los registrados */
                        $equal = true;

                        foreach ($product['warehouse_product_attributes'] as $attribute) {
                            $name = $attribute['name'];
                            $val = $attribute['value'];

                            $product_att = WarehouseProductAttribute::where('warehouse_product_id', $product_id)
                                ->where('name', $name)->first();

                            if (!is_null($product_att)) {
                                $product_value = WarehouseProductValue::where('value', $val)
                                    ->where('warehouse_product_attribute_id', $product_att->id)
                                    ->where('warehouse_inventory_product_id', $product_inventory->id)->first();

                                if (is_null($product_value)) {
                                    /** si el valor de este atributo no existe, son diferentes */
                                    $equal = false;
                                    break;
                                }
                            } else {
                                $equal = false;
                                break;
                            }
                        }
                        if ($equal === true) {
                            
                            /** Se genera el movimiento, para su posterior aprobación */

                            $inventory_movement = WarehouseInventoryProductMovement::create([
                                'quantity' => $quantity,
                                'new_value' => $value,
                                'warehouse_movement_id' => $movement->id,
                                'warehouse_inventory_product_id' => $product_inventory->id,
                            ]);
                        }
                    }
                } elseif ((count($inventory) == 0) || ($equal == false)) {
                    /**
                     * Si no existe un registro previo de ese producto en inventario o algún atributo es diferente
                     * se genera un nuevo registro
                     */
                    $codeSetting = CodeSetting::where('table', 'warehouse_inventory_products')->first();
                    
                    $codep  = generate_registration_code(
                        $codeSetting->format_prefix,
                        strlen($codeSetting->format_digits),
                        (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
                        $codeSetting->model,
                        $codeSetting->field
                    );
                    
                    $product_inventory = WarehouseInventoryProduct::create([
                        'code' => $codep,
                        'warehouse_product_id' => $product_id,
                        'currency_id' => $currency,
                        'unit_value' => $value,
                        'warehouse_institution_warehouse_id' => $inst_ware->id,
                    ]);

            
                    $inventory_movement = WarehouseInventoryProductMovement::create([
                        'quantity' => $quantity,
                        'new_value' => $value,
                        'warehouse_movement_id' => $movement->id,
                        'warehouse_inventory_product_id' => $product_inventory->id,
                    ]);


                    foreach ($product['warehouse_product_attributes'] as $attribute) {
                        $name = $attribute['name'];
                        $value = $attribute['value'];

                        $field = WarehouseProductAttribute::where('warehouse_product_id', $product_id)
                            ->where('name', $name)->first();


                        WarehouseProductValue::create([
                            'value' => $value,
                            'warehouse_product_attribute_id' => $field->id,
                            'warehouse_inventory_product_id' => $product_inventory->id,
                        ]);
                    }
                }
            }
        });
        $warehouse_movement = WarehouseMovement::where('code', $code)->first();
        if (is_null($warehouse_movement)) {
            $request->session()->flash(
                'message',
                [
                    'type' => 'other',
                    'title' => 'Alerta',
                    'icon' => 'screen-error',
                    'class' => 'growl-danger',
                    'text' => 'No se pudo completar la operación.'
                ]
            );
        } else {
            $request->session()->flash('message', ['type' => 'store']);
        }
        return response()->json(['result' => true, 'redirect' => route('warehouse.reception.index')], 200);
    }

    /**
     * Muestra el formulario para editar un Ingreso de Almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id Identificador único del ingreso de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function edit($id)
    {
        $reception = WarehouseMovement::find($id);
        return view('warehouse::receptions.create', compact("reception"));
    }

    /**
     * Actualiza la información de los Ingresos de Almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  Integer $id Identificador único del ingreso de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, $id)
    {
        $warehouse_movement = WarehouseMovement::find($id);
        $this->validate($request, [
            'warehouse_inventory_products' => ['required'],
            'warehouse_id' => ['required'],
            'institution_id' => ['required'],

        ]);

        $tam = count($request->warehouse_inventory_products);
        for ($i=0; $i< $tam; $i++) {
            $attributes = $request->warehouse_inventory_products[$i]['warehouse_product_attributes'];
            $att = count($attributes);
            $this->validate($request, [
                'warehouse_inventory_products.'.$i.'.warehouse_product_id' => ['required'],
                'warehouse_inventory_products.'.$i.'.quantity' => ['required'],
                'warehouse_inventory_products.'.$i.'.currency_id' => ['required'],
                'warehouse_inventory_products.'.$i.'.unit_value' => ['required'],
                
            ]);

            for ($j=0; $j < $att; $j++) {
                $this->validate($request, [
                    'warehouse_inventory_products.'.$i.'.warehouse_product_attributes.'.$j.'.name' => ['required'],
                    'warehouse_inventory_products.'.$i.'.warehouse_product_attributes.'.$j.'.value' => ['required'],
                ]);
            }
        }

        $product_movements = WarehouseInventoryProductMovement::where(
            'warehouse_movement_id',
            $warehouse_movement->id
        )->get();

        $inst_ware = WarehouseInstitutionWarehouse::where('warehouse_id', $request->warehouse_id)
            ->where('institution_id', $request->institution_id)->first();

        DB::transaction(function () use ($request, $warehouse_movement, $inst_ware, $product_movements) {
            $warehouse_movement->warehouse_institution_warehouse_end_id = $inst_ware->id;
            $warehouse_movement->user_id = Auth::id();
            $warehouse_movement->save();
            $equal = null;

            $update = now();
            /** Se agregan los nuevos elementos a la solicitud */

            foreach ($request->warehouse_inventory_products as $product) {
                $product_id = $product['warehouse_product_id'];
                $currency = $product['currency_id'];
                $quantity = $product['quantity'];
                $value = $product['unit_value'];

                /** Se busca en el inventario por producto y unidad si existe un registro previo */

                $inventory = WarehouseInventoryProduct::where('warehouse_product_id', $product_id)
                    ->where('warehouse_institution_warehouse_id', $inst_ware->id)
                    ->where('unit_value', $value)->get();

                /** Si existe un registro previo se verifican los atributos del nuevo ingreso */
                if (count($inventory) > 0) {
                    foreach ($inventory as $product_inventory) {
                        $old_inventory = $product_movements->where(
                            'warehouse_inventory_product_id',
                            $product_inventory->id
                        )->first();

                        $equal =  (is_null($old_inventory))?false:true;
                        if ($equal == true) {
                            /** Verificamos que tengan los mismos atributos */

                            foreach ($product['warehouse_product_attributes'] as $attribute) {
                                $name = $attribute['name'];
                                $val = $attribute['value'];

                                $product_att = WarehouseProductAttribute::where('warehouse_product_id', $product_id)
                                    ->where('name', $name)->first();

                                if (!is_null($product_att)) {
                                    $product_value = WarehouseProductValue::where('value', $val)
                                        ->where('warehouse_product_attribute_id', $product_att->id)
                                        ->where('warehouse_inventory_product_id', $product_inventory->id)->first();

                                    #si el valor de este atributo no existe, son diferentes
                                    if (is_null($product_value)) {
                                        $equal = false;
                                        break;
                                    }
                                } else {
                                    $equal = false;
                                    break;
                                }
                            }
                            /** Si todos los atributos de este producto son iguales ajustamos la existencia */
                            if ($equal == true) {
                                $old_inventory->quantity = $quantity;
                                $old_inventory->new_value = $value;
                                $old_inventory->updated_at = $update;
                                $old_inventory->save();
                            }
                        }
                    }
                }
                /** Si no existe un registro previo de ese producto en inventario
                 * ó algún atributo es diferente (se genera un nuevo registro)
                 */
                if ((count($inventory) == 0) || ($equal == false)) {
                    $codeSetting = CodeSetting::where('table', 'warehouse_inventory_products')->first();
                    
                    $codep  = generate_registration_code(
                        $codeSetting->format_prefix,
                        strlen($codeSetting->format_digits),
                        (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
                        $codeSetting->model,
                        $codeSetting->field
                    );
                    
                    $product_inventory = WarehouseInventoryProduct::create([
                        'code' => $codep,
                        'warehouse_product_id' => $product_id,
                        'currency_id' => $currency,
                        'unit_value' => $value,
                        'warehouse_institution_warehouse_id' => $inst_ware->id,
                    ]);
            
                    $inventory_movement = WarehouseInventoryProductMovement::create([
                        'quantity' => $quantity,
                        'new_value' => $value,
                        'warehouse_movement_id' => $warehouse_movement->id,
                        'warehouse_inventory_product_id' => $product_inventory->id,
                        'updated_at' => $update,
                    ]);

                    foreach ($product['warehouse_product_attributes'] as $attribute) {
                        $name = $attribute['name'];
                        $value = $attribute['value'];

                        $field = WarehouseProductAttribute::where('warehouse_product_id', $product_id)
                            ->where('name', $name)->first();

                        WarehouseProductValue::create([
                            'value' => $value,
                            'warehouse_product_attribute_id' => $field->id,
                            'warehouse_inventory_product_id' => $product_inventory->id,
                        ]);
                    }
                }
            }

            /** Se eliminan los demas elementos de la solicitud */
            $warehouse_inventory_product_movements = WarehouseInventoryProductMovement::where(
                'warehouse_movement_id',
                $warehouse_movement->id
            )->where('updated_at', '!=', $update)->get();

            foreach ($warehouse_inventory_product_movements as $warehouse_inventory_product_movement) {
                $warehouse_inventory_product_movement->delete();
            }
        });
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('warehouse.reception.index')], 200);
    }

    /**
     * Elimina un ingreso de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id Identificador único del ingreso de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy($id)
    {
        $reception = WarehouseMovement::find($id);
        $reception->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Vizualiza la información de una recepción o ingreso de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id Identificador único del movimiento de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    
    public function vueInfo($id)
    {
        return response()->json(['records' => WarehouseMovement::where('id', $id)
            ->with(
                [
                    'warehouseInventoryProductMovements' => function ($query) {
                        $query->with(['warehouseInventoryProduct' => function ($query) {
                            $query->with(['warehouseProduct' => function ($query) {
                                $query->with('measurementUnit');
                            }, 'warehouseProductValues' => function ($query) {
                                $query->with('warehouseProductAttribute');
                            }, 'currency']);
                        }]);
                    }, 'warehouseInstitutionWarehouseInitial', 'warehouseInstitutionWarehouseEnd', 'user']
            )->first()], 200);
    }

    /**
     * Obtiene un listado de los ingresos de almacén registrados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vueList()
    {
        return response()->json([
            'records' => WarehouseMovement::whereNull('warehouse_institution_warehouse_initial_id')
            ->with(
                'warehouseInstitutionWarehouseInitial',
                'warehouseInstitutionWarehouseEnd',
                'user'
            )->get()], 200);
    }

    /**
     * Rechaza el ingreso de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id Identificador único del ingreso de almacén
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function rejectedReception(Request $request, $id)
    {
        $warehouse_reception = WarehouseMovement::find($id);
        $warehouse_reception->state = 'Rechazado';
        $warehouse_reception->save();

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('warehouse.reception.index')], 200);
    }

    /**
     * Aprueba el ingreso de almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  Integer $id Identificador único del ingreso de almacén
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function approvedReception(Request $request, $id)
    {
        $warehouse_reception = WarehouseMovement::find($id);
        $warehouse_reception->state = 'Aprobado';
        $warehouse_reception->save();

        $warehouse_inventory_product_movements = $warehouse_reception->WarehouseInventoryProductMovements;
        foreach ($warehouse_inventory_product_movements as $warehouse_inventory_product_movement) {
            $warehouse_inventory_product = $warehouse_inventory_product_movement->WarehouseInventoryProduct;
            if ($warehouse_inventory_product->exist > 0) {
                $warehouse_inventory_product->exist += $warehouse_inventory_product_movement->quantity;
                $warehouse_inventory_product->save();
            } else {
                $warehouse_inventory_product->exist = $warehouse_inventory_product_movement->quantity;
                $warehouse_inventory_product->save();
            }
        }
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('warehouse.reception.index')], 200);
    }
}
