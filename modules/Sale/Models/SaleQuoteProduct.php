<?php

namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;
use App\Models\Currency;
use App\Models\HistoryTax;

/**
 * @class SaleQuoteProduct
 * @brief Modelo para la gestion de los productos de cotizaciones en comercializacion
 *
 * Modelo para la gestion de los productos de cotizaciones en comercializacion
 *
 * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class SaleQuoteProduct extends Model implements Auditable
{
    use SoftDeletes;
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
    protected $fillable = [
      'value',
      'product_type',
      'sale_quote_id',
      'currency_id',
      'measurement_unit_id',
      'quantity',
      'total',
      'total_without_tax',
      'sale_warehouse_inventory_product_id',
      'sale_type_good_id',
      'history_tax_id',
      'sale_list_subservices_id',
    ];

    /**
     * Método que establece las unidades monetarias almacenadas en el sistema
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * Currency
     */
    public function Currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * Método que obtiene la unidad de medida
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * MeasurementUnit
     */
    public function measurementUnit()
    {
        return $this->belongsTo(\App\Models\MeasurementUnit::class);
    }

    /**
     * Método que obtiene los tipos de bien
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne Objeto con el registro relacionado al modelo
     * saleTypeGood
     */
    public function saleTypeGood()
    {
        return $this->belongsTo(SaleTypeGood::class);
    }

    /**
     * Método que obtiene el producto de almacen (warehouse) en la cotizacion
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * saleWarehouseInventoryProduct
     */
    public function saleWarehouseInventoryProduct()
    {
        return $this->belongsTo(SaleWarehouseInventoryProduct::class);
    }

    /**
     * Método que obtiene los impuestos del producto
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * historyTax
     */
    public function historyTax()
    {
        return $this->belongsTo(HistoryTax::class);
    }

    /**
     * Método que obtiene lista de Subservicios del producto
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleListSubservices
     */
    public function SaleListSubservices()
    {
        return $this->belongsTo(SaleListSubservices::class);
    }
}
