<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class WarehouseInventoryProductMovement
 * @brief Datos de los movimientos de los productos entre almacenes
 *
 * Gestiona el modelo de datos de los productos para los movimientos de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseInventoryProductMovement extends Model implements Auditable
{
    use AuditableTrait;

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = [
        'quantity', 'new_value', 'warehouse_movement_id', 'warehouse_initial_inventory_product_id',
        'warehouse_inventory_product_id'
    ];

    /**
     * Método que obtiene el registro en el inventario del producto movilizado
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * WarehouseInventoryProduct
     */
    public function warehouseInventoryProduct()
    {
        return $this->belongsTo(WarehouseInventoryProduct::class);
    }

    /**
     * Método que obtiene el registro en el inventario del producto que se va movilizar
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * WarehouseInventoryProduct
     */
    public function warehouseInitialInventoryProduct()
    {
        return $this->belongsTo(WarehouseInventoryProduct::class);
    }

    /**
     * Método que obtiene el movimiento de almacén asociado al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * WarehouseMovement
     */
    public function warehouseMovement()
    {
        return $this->belongsTo(WarehouseMovement::class);
    }
}
