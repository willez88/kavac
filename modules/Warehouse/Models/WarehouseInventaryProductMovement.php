<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class WarehouseInventaryProductMovement
 * @brief Datos de los Movimientos de los Productos entre almacenes
 * 
 * Gestiona el modelo de datos de los productos para los movimientos de almacén
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseInventaryProductMovement extends Model implements Auditable
{
	use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Establece el uso o no de bitácora de registros para este modelo
     * @var boolean $revisionCreationsEnabled
     */
    protected $revisionCreationsEnabled = true;

    /**
     * Lista de atributos para la gestión de fechas
     *
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['quantity', 'new_value', 'reference', 'user_id', 'movement_id','inventary_product_id'];

    /**
     * Método que obtiene el inventario del producto
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo WarehouseInventaryProduct
     */

    public function inventary()
    {
        return $this->belongsTo('Modules\Warehouse\Models\WarehouseInventaryProduct','inventary_product_id');
    }

    /**
     * Método que obtiene el movimiento realizado
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo WarehouseMovement
     */

    public function movement()
    {
        return $this->belongsTo('Modules\Warehouse\Models\WarehouseMovement','movement_id');
    }
}
