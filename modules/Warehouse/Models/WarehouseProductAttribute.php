<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class WarehouseProductAttribute
 * @brief Datos de los atributos personalizados de los productos
 *
 * Gestiona el modelo de datos de los atributos personalizados de los productos
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseProductAttribute extends Model
{
    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['name', 'warehouse_product_id'];

    /**
     * Método que obtiene los productos almacenables
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * WarehouseProduct
     */
    public function warehouseProduct()
    {
        return $this->belongsTo(WarehouseProduct::class);
    }

    /**
     * Método que obtiene los valores de los atributos del producto
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne Objeto con el registro relacionado al modelo
     * WarehouseProductValue
     */
    public function warehouseProductValue()
    {
        return $this->hasOne(WarehouseProductValue::class);
    }
}
