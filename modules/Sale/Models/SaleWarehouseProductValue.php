<?php

namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class SaleWarehouseProductValue
 * @brief Datos de los valores de los atributos de los productos de almacén
 *
 * Gestiona el modelo de datos de los valores de los atributos de los productos de almacén
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class SaleWarehouseProductValue extends Model
{
    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['value', 'warehouse_inventory_product_id'];

    
    /**
     * Método que obtiene el producto relacionado con el registro
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * WarehouseProductAttribute
     */
    public function saleWarehouseInventoryProduct()
    {
        return $this->belongsTo(SaleWarehouseInventoryProduct::class);
    }
}
