<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class WarehouseMovement
 * @brief Historial de los movimientos de almacén
 * 
 * Gestiona el modelo de datos para lmovimientos de almacén
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseMovement extends Model implements Auditable
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
    protected $fillable = ['type', 'observation', 'complete', 'warehouse_inst_start_id', 'warehouse__inst_finish_id','user_id'];


    /**
     * Método que obtiene el registro de institución gestiona almacén de donde parten los artículos
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo WarehouseInstitutionWarehouses
     */
    public function start()
    {
        return $this->belongsTo('Modules\Warehouse\Models\WarehouseInstitutionWarehouse','warehouse_inst_start_id');
    }

    /**
     * Método que obtiene el registro de institución gestiona almacén donde llegan los artículos
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo WarehouseInstitutionWarehouses
     */
    public function finish()
    {
        return $this->belongsTo('Modules\Warehouse\Models\WarehouseInstitutionWarehouse','warehouse_inst_finish_id');
    }

    /**
     * Método que obtiene el usuario que registra el movimiento
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo Users
     */
    public function user()
    {
        return $this->belongsTo('App\User','user_id');
    }

    /**
     * Método que obtiene los cambios en los productos relacionados con el movimiento de almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo WarehouseInventaryProduct
     */
    public function products()
    {
        return $this->hasMany('Modules\Warehouse\Models\WarehouseInventaryProduct');
    }
}

