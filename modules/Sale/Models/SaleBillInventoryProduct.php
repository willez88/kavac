<?php

namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

class SaleBillInventoryProduct extends Model implements Auditable
{
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['currency_id', 'history_tax_id', 'measurement_unit_id', 'sale_goods_to_be_traded_id', 'sale_list_subservices_id', 'value', 'product_type', 'quantity', 'sale_warehouse_inventory_product_id', 'sale_bill_id'];

    /**
     * Método que obtiene las formas de pago almacenadas en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * Currency
     */
    public function Currency()
    {
        return $this->belongsTo(\App\Models\Currency::class);
    }

    /**
     * Método que obtiene los porcentajes de impuestos almacenados en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * HistoryTax
     */
    public function historyTax()
    {
        return $this->belongsTo(\App\Models\HistoryTax::class);
    }

    /**
     * Método que obtiene la unidad de medida
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * MeasurementUnit
     */
    public function measurementUnit()
    {
        return $this->belongsTo(\App\Models\MeasurementUnit::class);
    }

    /**
     * Método que obtiene los registros del modelo de bienes a comercializar
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo Objeto con el registro relacionado al modelo
     * saleTypeGood
     */
    public function saleGoodsToBeTraded()
    {
        return $this->belongsTo(SaleGoodsToBeTraded::class);
    }

    /**
     * Método que obtiene la lista de clientes del módulo de comercialización
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleBill
     */
    public function SaleBill()
    {
        return $this->belongsTo(\Modules\Sale\SaleBill::class);
    }

    /**
     * Método que obtiene el producto asociado al inventario
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleWarehouseInventoryProduct
     */
    public function saleWarehouseInventoryProduct()
    {
        return $this->belongsTo(SaleWarehouseInventoryProduct::class);
    }

    /**
     * Método que obtiene la lista de subservicios registrados en
     * el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo Objeto con el registro relacionado al modelo
     * SaleListSubservices
     */
    public function saleListSubservices()
    {
        return $this->belongsTo(SaleListSubservices::class);
    }
}
