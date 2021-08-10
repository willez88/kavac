<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Sale\Models\SaleTypeGoodAttribute;
use Modules\Sale\Models\SaleTypeGood;

/**
 * @class SaleTypeGoodController
 * @brief Controlador de los productos de almacén
 *
 * Clase que gestiona los productos almacenables
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class SaleTypeGoodController extends Controller
{
    use ValidatesRequests;

    /**
     * Define la configuración de la clase
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     */
    public function __construct()
    {
        /** Establece permisos de acceso para cada método del controlador */
        // $this->middleware('permission:sale.setting.type-good');
    }

    /**
     * Muestra un listado de los tipos de bienes registrados
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */
    public function index()
    {
        return response()->json(['records' => SaleTypeGood::with('saleTypeGoodAttribute')->get()], 200);
    }

    /**
     * Valida y Registra un nuevo tipo de bien
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'                => ['required', 'unique:sale_type_goods,name', 'max:60'],
            'description'         => ['required']

        ]);

        $typeGood = SaleTypeGood::create([
            'name'                => $request->input('name'),
            'description'         => $request->input('description'),
            'define_attributes'   => !empty($request->define_attributes)
                                        ? $request->input('define_attributes')
                                        : false
        ]);

        if ($typeGood->define_attributes) {
            foreach ($request->sale_type_good_attribute as $att) {
                $attribute = SaleTypeGoodAttribute::create([
                    'name'                 => $att['name'],
                    'sale_type_good_id' => $typeGood->id
                ]);
            }
        };
        
        return response()->json(['record' => $typeGood, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del tipo de bien
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  \Modules\Sale\Models\SaleTypeGood $typeGood (Registro a ser actualizado)
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */
    public function update(Request $request, SaleTypeGood $typeGood)
    {
        $this->validate($request, [
            'name'                => ['required', 'max:100'],
            'description'         => ['required']
        ]);

        $typeGood->name                = $request->input('name');
        $typeGood->description         = $request->input('description');
        $typeGood->define_attributes   =  !empty($request->define_attributes)
                                          ? $request->input('define_attributes')
                                          : false;

        $typeGood->save();

        $type_good_attribute = SaleTypeGoodAttribute::where('sale_type_good_id', $typeGood->id)->get();

        /** Busco si en la solicitud se eliminaron atributos registrados anteriormente */
        foreach ($type_good_attribute as $type_good_att) {
            $equal = false;
            foreach ($request->sale_type_good_attribute as $att) {
                if ($att["name"] == $type_good_att->name) {
                    $equal = true;
                    break;
                }
            }
            if ($equal == false) {
                $value = $type_good_att->saleTypeGoodValue();
                if ($value) {
                    $value->delete();
                }
                $type_good_att->delete();
            }
        }

        /** Registro los nuevos atributos */
        if ($typeGood->define_attributes == true) {
            foreach ($request->sale_type_good_attribute as $att) {
                $attribute = SaleTypeGoodAttribute::where('name', $att['name'])
                             ->where('sale_type_good_id', $typeGood->id)->first();
                if (is_null($attribute)) {
                    $attribute = SaleTypeGoodAttribute::create([
                        'name' => $att['name'],
                        'sale_type_good_id' => $typeGood->id
                    ]);
                }
            }
        };

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina un Tipo de bien
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  $id Identificador único del tipo de bien
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */
    public function destroy(SaleTypeGood $typeGood)
    {
        $typeGood->delete();
        return response()->json(['record' => $typeGood, 'message' => 'Success'], 200);
    }


    /**
     * Muestra una lista de los atributos de un producto
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return JsonResponse
     */

    public function getSaleTypeGoodsAttributes()
    {
        return response()->json([
            'records' => SaleTypeGoodAttribute::with('saleTypeGood')->get()
        ]);
    }

    /**
     * Muestra una lista de los tipos de bienes
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return JsonResponse
     */

    public function getSaleTypeGoods()
    {
        $records = [];
        $typeGoods = SaleTypeGood::orderBy('id', 'ASC')->get();

        array_push($records, ['id' => '', 'text' => 'Seleccione...']);

        foreach ($typeGoods as $typeGood) {
            array_push($records, [
                'id'            => $typeGood->id,
                'name'          => $typeGood->name,
                'text'          => $typeGood->name,
            ]);
        }
        return response()->json(['records' => $records], 200);
    }
}
