<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//use Venturecraft\Revisionable\RevisionableTrait;
/*use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;*/

/**
 * @class Warehouse
 * @brief Datos de los almacenes registrados
 *
 * Gestiona el modelo de datos para los almacenes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class Warehouse extends Model //implements Auditable
{
    use SoftDeletes;
    //use RevisionableTrait;
    //use AuditableTrait;

    /**
     * Establece el uso o no de bitácora de registros para este modelo
     *
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
     *
     * @var array $fillable
     */
    protected $fillable = ['name', 'active', 'address','parish_id'];

    /**
     * Método que obtiene la parroquia donde esta ubicado el almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo Parish
     */
    public function parish()
    {
        return $this->belongsTo(\App\Models\Parish::class);
    }

    /**
     * Método que obtiene las instituciones que gestionan el almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * WarehouseInstitutionWarehouse
     */
    public function warehouseInstitutionWarehouses()
    {
        return $this->hasMany(WarehouseInstitutionWarehouse::class);
    }
}
