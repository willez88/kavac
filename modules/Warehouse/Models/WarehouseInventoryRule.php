<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * @class WarehouseInventoryRule
 * @brief Datos de las reglas del inventario
 *
 * Gestiona el modelo de datos de las reglas del inventario de los productos
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseInventoryRule extends Model implements Recordable
{
    use SoftDeletes;
    use RecordableTrait;

    /**
     * Lista de atributos para la gestión de fechas
     *
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['minimum', 'maximum', 'warehouse_inventory_product_id', 'user_id'];

    /**
     * Método que obtiene el usuario que realiza el cambio de regla
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo  User
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * Método que obtiene el registro del producto en el inventario
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * WarehouseInventoryProduct
     */
    public function warehouseInventoryProduct()
    {
        return $this->belongsTo(WarehouseInventoryProduct::class);
    }
}
