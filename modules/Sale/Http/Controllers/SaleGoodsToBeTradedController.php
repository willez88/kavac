<?php

namespace Modules\Sale\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Modules\Sale\Models\SaleGoodsToBeTraded;
use Modules\Sale\Models\SaleGoodsAttribute;

/**
 * @class SaleGoodsToBeTradedController
 * @brief Gestionar bienes a Comercializar en el sistema.
 *
 * Gestionar bienes a Comercializar.
 *
 * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class SaleGoodsToBeTradedController extends Controller
{
    use ValidatesRequests;
    /**
     * [descripción del método]
     *
     * @method    index
     *
     * @author    Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     *
     * @return    Renderable    [description de los datos devueltos]
     */
    public function index()
    {
        return response()->json(['records' => SaleGoodsToBeTraded::with(['saleGoodsAttribute', 'currency', 'measurementUnit', 'department', 'historyTax', 'payrollStaff', 'saleTypeGood'])->get()], 200);
    }


    /**
     * Valida y Registra un nuevo bien a comercializar
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'                => ['required', 'unique:sale_goods_to_be_tradeds,name', 'max:100'],
            'description'         => ['required'],
            'unit_price'          => ['required', 'min:0'],
            'currency_id'         => ['required'],
            'measurement_unit_id' => ['required'],
            'department_id'       => ['required'],
            'payroll_staff_id'    => ['required'],
            'description'         => ['required'],

        ]);

        $goodToBeTraded = SaleGoodsToBeTraded::create([
            'name'                => $request->input('name'),
            'description'         => $request->input('description'),
            'unit_price'          => $request->input('unit_price'),
            'currency_id'         => $request->input('currency_id'),
            'measurement_unit_id' => $request->input('measurement_unit_id'),
            'department_id'       => $request->input('department_id'),
            'history_tax_id'              => $request->input('history_tax_id'),
            'payroll_staff_id'    => $request->input('payroll_staff_id'),
            'sale_type_good_id'   => $request->input('sale_type_good_id'),
            'define_attributes'   => !empty($request->define_attributes)
                                        ? $request->input('define_attributes')
                                        : false
        ]);

        if ($goodToBeTraded->define_attributes) {
            foreach ($request->sale_goods_attribute as $att) {
                $attribute = SaleGoodsAttribute::create([
                    'name'                 => $att['name'],
                    'sale_goods_to_be_traded_id' => $goodToBeTraded->id
                ]);
            }
        };
        
        return response()->json(['record' => $goodToBeTraded, 'message' => 'Success'], 200);
    }

    /**
     * Actualiza la información del de un bien registrado
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  \Illuminate\Http\Request  $request (Datos de la petición)
     * @param  $id (id del registro a ser actualizado)
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name'                => ['required', 'max:100'],
            'description'         => ['required'],
            'unit_price'          => ['required', 'integer', 'min:1'],
            'currency_id'         => ['required'],            
            'measurement_unit_id' => ['required'],
            'department_id'       => ['required'],
            'payroll_staff_id'    => ['required'],
            'description'         => ['required'],
        ]);

        $goodsToBeTraded = SaleGoodsToBeTraded::find($id);

        $goodsToBeTraded->name                = $request->input('name');
        $goodsToBeTraded->description         = $request->input('description');
        $goodsToBeTraded->unit_price          = $request->input('unit_price');
        $goodsToBeTraded->currency_id         = $request->input('currency_id');
        $goodsToBeTraded->measurement_unit_id = $request->input('measurement_unit_id');
        $goodsToBeTraded->department_id       = $request->input('department_id');
        $goodsToBeTraded->history_tax_id      = $request->input('history_tax_id');
        $goodsToBeTraded->payroll_staff_id    = $request->input('payroll_staff_id');
        $goodsToBeTraded->sale_type_good_id   = $request->input('sale_type_good_id');
        $goodsToBeTraded->define_attributes   =  !empty($request->define_attributes)
                                          ? $request->input('define_attributes')
                                          : false;

        $goodsToBeTraded->save();

        $goods_attribute = SaleGoodsAttribute::where('sale_goods_to_be_traded_id', $goodsToBeTraded->id)->get();

        /** Busco si en la solicitud se eliminaron atributos registrados anteriormente */
        foreach ($goods_attribute as $goods_att) {
            $equal = false;
            foreach ($request->sale_goods_attribute as $att) {
                if ($att["name"] == $goods_att->name) {
                    $equal = true;
                    break;
                }
            }
        }

        /** Registro los nuevos atributos */
        if ($goodsToBeTraded->define_attributes == true) {
            foreach ($request->sale_goods_attribute as $att) {
                $attribute = SaleGoodsAttribute::where('name', $att['name'])
                             ->where('sale_goods_to_be_traded_id', $goodsToBeTraded->id)->first();
                if (is_null($attribute)) {
                    $attribute = SaleGoodsAttribute::create([
                        'name' => $att['name'],
                        'sale_goods_to_be_traded_id' => $goodsToBeTraded->id
                    ]);
                }
            }
        };

        return response()->json(['message' => 'Success'], 200);
    }

    /**
     * Elimina un bien a comercializar registrado en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @param  $id Identificador único del tipo de bien
     * @return \Illuminate\Http\JsonResponse (JSON con los registros a mostrar)
     */
    public function destroy(SaleGoodsToBeTraded $goodsToBeTraded)
    {
        $goodsToBeTraded->delete();
        return response()->json(['record' => $goodsToBeTraded, 'message' => 'Success'], 200);
    }
    /**
     * Obtiene los Bienes a Comercializar.
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     * @return JsonResponse    Json con los datos de bienes a comercializar.
     */
    public function getSaleGoodsToBeTraded()
    {
        return response()->json(template_choices('Modules\Sale\Models\SaleGoodsToBeTraded', 'name', '', true));
    }

    /**
     * Muestra una lista de las monedas registradas en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return Array con los registros a mostrar
     */
    public function getCurrencies()
    {
        return template_choices('App\Models\Currency', ['symbol', '-', 'name'], '', true);
    }

    /**
     * Muestra una lista del porcentaje de impuestos registrados en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return Array con los registros a mostrar
     */
    public function getTaxes()
    {
        return template_choices('App\Models\HistoryTax', ['percentage'], '', true);
    }

    /**
     * Muestra una lista de las unidades / dependencias registradas en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return Array con los registros a mostrar
     */
    public function getDepartments()
    {
        return template_choices('App\Models\Department', ['acronym', '-', 'name'], '', true);
    }

    /**
     * Muestra una lista de los trabajadores registrados en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return Array con los registros a mostrar
     */
    public function getPayrollStaffs()
    {
        return template_choices('Modules\Payroll\Models\PayrollStaff', ['first_name',' ','last_name','-', 'id_number'], '', true);
    }

    /**
     * Muestra una lista de los atributos de un bien
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return JsonResponse
     */

    public function getSaleGoodsAttributes($good_id)
    {
        return response()->json([
            'records' => SaleGoodsAttribute::with('saleGoodsToBeTraded')->where(
                'sale_goods_to_be_traded_id',
                $good_id
            )->get()
        ]);
    }

    /**
     * Muestra una lista de los bienes a comercializar
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return JsonResponse
     */

    public function getSaleGoods()
    {
        $records = [];
        $goods = SaleGoodsToBeTraded::with(['department', 'payrollStaff' => function ($query) {
            $query->with('phones');
        }])->orderBy('id', 'ASC')->get();

        array_push($records, ['id' => '', 'text' => 'Seleccione...']);

        foreach ($goods as $good) {
            $phone = '';
            foreach($good->payrollStaff->phones as $phone){
                $phone = $phone->extension.'-'.$phone->area_code.$phone->number;
            }
            array_push($records, [
                'id'                   => $good->id,
                'name'                 => $good->name,
                'description'          => $good->description,
                'department'           => $good->department->name,
                'staff_name'           => $good->payrollStaff->first_name,
                'staff_last_name'      => $good->payrollStaff->last_name,
                'staff_email'          => $good->payrollStaff->email,
                'staff_phone'          => $phone,
                'measurement_unit_id'  => $good->measurement_unit_id,
                'unit_price'           => $good->unit_price,
                'history_tax_id'       => $good->history_tax_id,
                'currency_id'          => $good->currency_id,
                'text'                 => $good->name,
            ]);
        }
        return response()->json(['records' => $records], 200);
    }
}
