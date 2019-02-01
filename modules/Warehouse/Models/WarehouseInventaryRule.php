<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class WarehouseInventaryRule
 * @brief Datos de las reglas del inventario 
 * 
 * Gestiona el modelo de datos de las reglas del inventario de los productos por almacén
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseInventaryRule extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;

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
    protected $fillable = ['min','inventary_id','user_id'];

    /**
     * Método que obtiene el usuario que realiza el cambio de regla
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo User
     */

    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    /**
     * Método que obtiene el registro del producto en el inventario
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo WarehouseInventaryProduct
     */

    public function inventary()
    {
        return $this->belongsTo('Modules\Warehouse\Models\WarehouseInventaryProduct','inventary_id');
    }
}
