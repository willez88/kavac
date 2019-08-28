<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class WarehouseProductValue
 * @brief Datos de los valores de los atributos de los productos de almacén
 *
 * Gestiona el modelo de datos de los valores de los atributos de los productos de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseProductValue extends Model
{
    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['value', 'warehouse_product_attribute_id', 'warehouse_inventory_product_id'];

    /**
     * Método que obtiene el atributo relacionado con el registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * WarehouseProductAttribute
     */
    public function warehouseProductAttribute()
    {
        return $this->belongsTo(WarehouseProductAttribute::class);
    }

    /**
     * Método que obtiene el producto relacionado con el registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * WarehouseProductAttribute
     */
    public function warehouseInventoryProduct()
    {
        return $this->belongsTo(WarehouseInventoryProduct::class);
    }
}
