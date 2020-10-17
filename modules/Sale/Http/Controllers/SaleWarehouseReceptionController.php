<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\CodeSetting;

use Modules\Sale\Models\SaleWarehouseInventoryProductMovement;
use Modules\Sale\Models\SaleWarehouseInstitutionWarehouse;
use Modules\Sale\Models\SaleWarehouseInventoryProduct;
use Modules\Sale\Models\SaleWarehouseProductValue;
use Modules\Sale\Models\SaleWarehouseMovement;
use Modules\Sale\Models\SaleSettingProduct;

/**
 * @class SaleWarehouseReceptionController
 * @brief Controlador de recepciones de almacén
 *
 * Clase que gestiona las recepciones de los productos al almacén
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class SaleWarehouseReceptionController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     */
    public function __construct()
    {

        /** Establece permisos de acceso para cada método del controlador 
        $this->middleware('permission:sale.movement.list', ['only' => 'index']);
        $this->middleware('permission:sale.movement.create', ['only' => ['create', 'store']]);
        $this->middleware('permission:sale.movement.edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:sale.movement.delete', ['only' => 'destroy']);
        */
    }

    /**
     * Muestra un listado de las Recepciones o Ingresos de Almacén
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return view('sale::receptions.list');
    }

    /**
     * Muestra el formulario para registrar un nuevo Ingreso de Almacén
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function create()
    {
        return view('sale::receptions.create');
    }

    /**
     * Valida y Registra un nuevo Ingreso de Almacén
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'sale_warehouse_inventory_products' => ['required'],
            'sale_warehouse_id' => ['required'],
            'institution_id' => ['required'],

        ]);
        
        $codeSetting = CodeSetting::where('table', 'sale_warehouse_movements')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('sale.settings.index')], 200);
        }

        $code  = generate_registration_code(
            $codeSetting->format_prefix,
            strlen($codeSetting->format_digits),
            (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
            $codeSetting->model,
            $codeSetting->field
        );
        $codeSetting = CodeSetting::where('table', 'sale_warehouse_inventory_products')->first();
        if (is_null($codeSetting)) {
            $request->session()->flash('message', [
                'type' => 'other', 'title' => 'Alerta', 'icon' => 'screen-error', 'class' => 'growl-danger',
                'text' => 'Debe configurar previamente el formato para el código a generar'
                ]);
            return response()->json(['result' => false, 'redirect' => route('sale.settings.index')], 200);
        }

        $tam = count($request->sale_warehouse_inventory_products);
        $i=0;
        for ($i=0; $i < $tam; $i++) {
            $this->validate($request, [
                'sale_warehouse_inventory_products.'.$i.'.sale_setting_product_id' => ['required'],
                'sale_warehouse_inventory_products.'.$i.'.quantity' => ['required'],
                'sale_warehouse_inventory_products.'.$i.'.currency_id' => ['required'],
                'sale_warehouse_inventory_products.'.$i.'.measurement_unit_id' => ['required'],
                'sale_warehouse_inventory_products.'.$i.'.unit_value' => ['required'],
                
            ]);
        }


        /*********************************************************/
        $inst_ware = SaleWarehouseInstitutionWarehouse::where('sale_warehouse_id', $request->sale_warehouse_id)
            ->where('institution_id', $request->institution_id)->first();

        DB::transaction(function () use ($request, $inst_ware, $code) {
            $movement = SaleWarehouseMovement::create([
                'code' => $code,
                'type' => 'C',
                'state' => 'Pendiente',
                'description' => 'Registro manual de productos en el inventario del almacén',
                'sale_warehouse_institution_warehouse_end_id' => $inst_ware->id,
                'user_id' => Auth::id(),
            ]);

            $equal = null;
                
            foreach ($request->sale_warehouse_inventory_products as $product) {
                $product_id = $product['sale_setting_product_id'];
                $currency = $product['currency_id'];
                $measurement_unit = $product['measurement_unit_id'];
                $quantity = $product['quantity'];
                $value = $product['unit_value'];

                /** Se busca en el inventario por producto y unidad si existe un registro previo */

                $inventory = SaleWarehouseInventoryProduct::where('sale_setting_product_id', $product_id)
                    ->where('sale_warehouse_institution_warehouse_id', $inst_ware->id)
                    ->where('unit_value', $value)->get();

                /** Si existe un registro previo se verifican los atributos del nuevo ingreso */
                if (count($inventory) > 0) {
                    foreach ($inventory as $product_inventory) {
                        /** @var boolean $equal Define si los atributos coinciden con los registrados */
                        $equal = true;

                        foreach ($product['sale_setting_products'] as $attribute) {
                            $name = 'sale_setting_product.name';

                            $product_att = SaleSettingProduct::where('id', $product_id)
                                ->where('name', $name)->first();

                            if (!is_null($product_att)) {
                                $product_value = SaleWarehouseProductValue::where('value', $val) 
                                    ->where('sale_warehouse_inventory_product_id', $product_inventory->id)->first();

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

                            $inventory_movement = SaleWarehouseInventoryProductMovement::create([
                                'quantity' => $quantity,
                                'new_value' => $value,
                                'sale_warehouse_movement_id' => $movement->id,
                                'sale_warehouse_inventory_product_id' => $product_inventory->id,
                            ]);
                        }
                    }
                } elseif ((count($inventory) == 0) || ($equal == false)) {
                    /**
                     * Si no existe un registro previo de ese producto en inventario o algún atributo es diferente
                     * se genera un nuevo registro
                     */
                    $codeSetting = CodeSetting::where('table', 'sale_warehouse_inventory_products')->first();
                    
                    $codep  = generate_registration_code(
                        $codeSetting->format_prefix,
                        strlen($codeSetting->format_digits),
                        (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
                        $codeSetting->model,
                        $codeSetting->field
                    );
                    
                    $product_inventory = SaleWarehouseInventoryProduct::create([
                        'code' => $codep,
                        'sale_setting_product_id' => $product_id,
                        'currency_id' => $currency,
                        'measurement_unit_id' => $measurement_unit,
                        'unit_value' => $value,
                        'sale_warehouse_institution_warehouse_id' => $inst_ware->id,
                    ]);
            
                    $inventory_movement = SaleWarehouseInventoryProductMovement::create([
                        'quantity' => $quantity,
                        'new_value' => $value,
                        'sale_warehouse_movement_id' => $movement->id,
                        'sale_warehouse_inventory_product_id' => $product_inventory->id,
                    ]);
                }
            }
        });
        

        $sale_warehouse_movement = SaleWarehouseMovement::where('code', $code)->first();
        if (is_null($sale_warehouse_movement)) {
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
        return response()->json(['result' => true, 'redirect' => route('sale.reception.index')], 200);
    }

    /**
     * Muestra el formulario para editar un Ingreso de Almacén
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  Integer $id Identificador único del ingreso de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function edit($id)
    {
        $reception = SaleWarehouseMovement::find($id);
        return view('sale::receptions.create', compact("reception"));
    }

    /**
     * Actualiza la información de los Ingresos de Almacén
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  Integer $id Identificador único del ingreso de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, $id)
    {
        $sale_warehouse_movement = SaleWarehouseMovement::find($id);
        $this->validate($request, [
            'sale_warehouse_inventory_products' => ['required'],
            'sale_warehouse_id' => ['required'],
            'institution_id' => ['required'],

        ]);

        $tam = count($request->sale_warehouse_inventory_products);
        for ($i=0; $i< $tam; $i++) {
            $this->validate($request, [
                'sale_warehouse_inventory_products.'.$i.'.sale_setting_product_id' => ['required'],
                'sale_warehouse_inventory_products.'.$i.'.quantity' => ['required'],
                'sale_warehouse_inventory_products.'.$i.'.currency_id' => ['required'],
                'sale_warehouse_inventory_products.'.$i.'.measurement_unit_id' => ['required'],
                'sale_warehouse_inventory_products.'.$i.'.unit_value' => ['required'],
                
            ]);
        }

        $product_movements = SaleWarehouseInventoryProductMovement::where(
            'sale_warehouse_movement_id',
            $sale_warehouse_movement->id
        )->get();

        $inst_ware = SaleWarehouse::where('institution_id', $request->institution_id)->first();

        DB::transaction(function () use ($request, $sale_warehouse_movement, $inst_ware, $product_movements) {
            $sale_warehouse_movement->sale_warehouse_institution_warehouse_end_id = $inst_ware->id;
            $sale_warehouse_movement->user_id = Auth::id();
            $sale_warehouse_movement->save();
            
            $update = now();
            /** Se agregan los nuevos elementos a la solicitud */

            foreach ($request->warehouse_inventory_products as $product) {
                $product_id = $product['sale_setting_product_id'];
                $currency = $product['currency_id'];
                $measurement_unit = $product['measurement_unit_id'];
                $quantity = $product['quantity'];
                $value = $product['unit_value'];

                /** Se busca en el inventario por producto y unidad si existe un registro previo */

                $inventory = WarehouseInventoryProduct::where('sale_setting_product_id', $product_id)
                    ->where('sale_warehouse_id', $inst_ware->id)
                    ->where('unit_value', $value)->get();

                /** Si no existe un registro previo de ese producto en inventario
                 *  (se genera un nuevo registro)
                 */
                if ((count($inventory) == 0)) {
                    $codeSetting = CodeSetting::where('table', 'sale_warehouse_inventory_products')->first();
                    
                    $codep  = generate_registration_code(
                        $codeSetting->format_prefix,
                        strlen($codeSetting->format_digits),
                        (strlen($codeSetting->format_year) == 2) ? date('y') : date('Y'),
                        $codeSetting->model,
                        $codeSetting->field
                    );
                    
                    $product_inventory = SaleWarehouseInventoryProduct::create([
                        'code' => $codep,
                        'sale_setting_product_id' => $product_id,
                        'currency_id' => $currency,
                        'measurement_unit_id' => $measurement_unit,
                        'unit_value' => $value,
                        'sale_warehouse_id' => $inst_ware->id,
                    ]);
            
                    $inventory_movement = SaleWarehouseInventoryProductMovement::create([
                        'quantity' => $quantity,
                        'new_value' => $value,
                        'sale_warehouse_movement_id' => $sale_warehouse_movement->id,
                        'sale_warehouse_inventory_product_id' => $product_inventory->id,
                        'updated_at' => $update,
                    ]);
                }
            }

            /** Se eliminan los demas elementos de la solicitud */
            $sale_warehouse_inventory_product_movements = SaleWarehouseInventoryProductMovement::where(
                'sale_warehouse_movement_id',
                $sale_warehouse_movement->id
            )->where('updated_at', '!=', $update)->get();

            foreach ($sale_warehouse_inventory_product_movements as $sale_warehouse_inventory_product_movement) {
                $sale_warehouse_inventory_product_movement->delete();
            }
        });
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('sale.reception.index')], 200);
    }

    /**
     * Elimina un ingreso de almacén
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  Integer $id Identificador único del ingreso de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy($id)
    {
        $reception = SaleWarehouseMovement::find($id);
        $reception->delete();
        return response()->json(['message' => 'destroy'], 200);
    }

    /**
     * Vizualiza la información de una recepción o ingreso de almacén
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  Integer $id Identificador único del movimiento de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    
    public function vueInfo($id)
    {
        return response()->json(['records' => SaleWarehouseMovement::where('id', $id)
            ->with(
                [
                    'saleWarehouseInventoryProductMovements' => function ($query) {
                        $query->with(['saleWarehouseInventoryProduct' => function ($query) {
                                $query->with('measurementUnit');
                            }, 'saleWarehouseInventoryProduct' => function ($query) {
                                $query->with('saleSettingProduct');
                            }, 'currency']);

                    }, 'saleWarehouseInstitutionWarehouseInitial', 'saleWarehouseInstitutionWarehouseEnd', 'user']
            )->first()], 200);
    }

    /**
     * Obtiene un listado de los ingresos de almacén registrados
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse Objeto con los registros a mostrar
     */
    public function vueList()
    {
        return response()->json([
            'records' => SaleWarehouseMovement::whereNull('sale_warehouse_institution_warehouse_initial_id')
            ->with(
                'saleWarehouseInstitutionWarehouseInitial',
                'saleWarehouseInstitutionWarehouseEnd',
                'user'
            )->get()], 200);
    }

    /**
     * Rechaza el ingreso de almacén
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  Integer $id Identificador único del ingreso de almacén
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function rejectedReception(Request $request, $id)
    {
        $sale_warehouse_reception = SaleWarehouseMovement::find($id);
        $sale_warehouse_reception->state = 'Rechazado';
        $sale_warehouse_reception->save();

        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('sale.reception.index')], 200);
    }

    /**
     * Aprueba el ingreso de almacén
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  Integer $id Identificador único del ingreso de almacén
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function approvedReception(Request $request, $id)
    {
        $sale_warehouse_reception = SaleWarehouseMovement::find($id);
        $sale_warehouse_reception->state = 'Aprobado';
        $sale_warehouse_reception->save();

        $sale_warehouse_inventory_product_movements = $sale_warehouse_reception->SaleWarehouseInventoryProductMovements;
        foreach ($sale_warehouse_inventory_product_movements as $sale_warehouse_inventory_product_movement) {
            $sale_warehouse_inventory_product = $sale_warehouse_inventory_product_movement->SaleWarehouseInventoryProduct;
            if ($sale_warehouse_inventory_product->exist > 0) {
                $sale_warehouse_inventory_product->exist += $sale_warehouse_inventory_product_movement->quantity;
                $sale_warehouse_inventory_product->save();
            } else {
                $sale_warehouse_inventory_product->exist = $sale_warehouse_inventory_product_movement->quantity;
                $sale_warehouse_inventory_product->save();
            }
        }
        $request->session()->flash('message', ['type' => 'update']);
        return response()->json(['result' => true, 'redirect' => route('sale.reception.index')], 200);
    }

    /**
     * Muestra una lista de las unidades de medida
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return Array con los registros a mostrar
     */
    public function getMeasurementUnits()
    {
        return template_choices('App\Models\MeasurementUnit', ['acronym', '-', 'name'], '', true);
    }
}
