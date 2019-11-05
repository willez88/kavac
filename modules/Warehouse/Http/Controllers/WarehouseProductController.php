<?php

namespace Modules\Warehouse\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Warehouse\Models\WarehouseInventoryProduct;
use Modules\Warehouse\Models\WarehouseProductAttribute;
use Modules\Warehouse\Models\WarehouseProduct;

/**
 * @class WarehouseProductController
 * @brief Controlador de los productos de almacén
 *
 * Clase que gestiona los productos almacenables
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseProductController extends Controller
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
        $this->middleware('permission:warehouse.setting.product');
    }

    /**
     * Muestra un listado de los productos almacenables registrados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function index()
    {
        return response()->json(['records' => WarehouseProduct::with('warehouseProductAttributes')->get()], 200);
    }

    /**
     * Valida y Registra un nuevo producto almacenable
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'description' => ['required'],
            
        ]);

        $product = WarehouseProduct::create([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'define_attributes' => !empty($request->define_attributes)?$request->input('define_attributes'):false,
        ]);

        if ($product->define_attributes) {
            foreach ($request->warehouse_product_attributes as $att) {
                $attribute = WarehouseProductAttribute::create([
                    'name' => $att['name'],
                    'warehouse_product_id' => $product->id
                ]);
            }
        };

        return response()->json(['record' => $product, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información de los Productos Almacenables
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Warehouse\Models\WarehouseProduct $product (Registro a ser actualizado)
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function update(Request $request, WarehouseProduct $product)
    {
        $this->validate($request, [
            'name' => ['required', 'max:100'],
            'description' => ['required'],
        ]);

        $product->name = $request->input('name');
        $product->description = $request->input('description');
        $product->define_attributes =  !empty($request->define_attributes)?$request->input('define_attributes'):false;
        $product->save();

        $product_attributes = WarehouseProductAttribute::where('warehouse_product_id', $product->id)->get();

        /** Busco si en la solicitud se eliminaron atributos registrados anteriormente */
        foreach ($product_attributes as $product_att) {
            $equal = false;
            foreach ($request->warehouse_product_attributes as $att) {
                if ($att["name"] == $product_att->name) {
                    $equal = true;
                    break;
                }
            }
            if ($equal == false) {
                $value = $product_att->warehouseProductValue();
                if ($value) {
                    $value->delete();
                }
                $product_att->delete();
            }
        }

        /** Registro los nuevos atributos */
        if ($product->define_attributes == true) {
            foreach ($request->warehouse_product_attributes as $att) {
                $attribute = WarehouseProductAttribute::where('name', $att['name'])
                             ->where('warehouse_product_id', $product->id)->first();
                if (is_null($attribute)) {
                    $attribute = WarehouseProductAttribute::create([
                        'name' => $att['name'],
                        'warehouse_product_id' => $product->id
                    ]);
                }
            }
        };

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina un Producto Almacenable
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  $id Identificador único del movimiento de almacén
     * @return \Illuminate\Http\Response (JSON con los registros a mostrar)
     */
    public function destroy(WarehouseProduct $product)
    {
        $product->delete();
        return response()->json(['record' => $product, 'message' => 'Success'], 200);
    }
    
    /**
     * Muestra una lista de los productos almacenables para elementos del tipo select
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return Array con los registros a mostrar
     */

    public function getWarehouseProducts()
    {
        return template_choices('Modules\Warehouse\Models\WarehouseProduct', 'name', '', true);
    }

    /**
     * Muestra una lista de los atributos de un producto
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return Objeto con los registros a mostrar
     */

    public function getProductAttributes($product_id)
    {
        return response()->json(
            ['records' => WarehouseProductAttribute::where('warehouse_product_id', $product_id)->get()]
        );
    }

    /**
     * Muestra una lista de las unidades de medida de los productos almacenables para elementos del tipo select
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return Array con los registros a mostrar
     */
    public function getMeasurementUnits()
    {
        return template_choices('App\Models\MeasurementUnit', ['acronym', '-', 'name'], '', true);
    }

    /**
     * Muestra una lista de los productos registrados para su uso en elementos gráficos del sistema
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return Array con los registros a mostrar
     */
    public function getInventoryProducts($type, $order = 'desc')
    {
        $fields = WarehouseInventoryProduct::with('warehouseProduct', 'currency', 'measurementUnit');
        if ($type == 'exist') {
            $fields = ($order == 'desc')?$fields->orderBy('exist', 'desc')->get():
                $fields->orderBy('exist', 'asc')->get();
        } else {
            $fields = ($order == 'desc')?$fields->orderBy('reserved', 'desc')->get():
                $fields->orderBy('reserved', 'asc')->get();
        }
        return response()->json(['records' => $fields], 200);
    }
}
