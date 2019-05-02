<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class WarehouseInstitutionWarehouse
 * @brief Datos de los Almacenes de cada institución
 * 
 * Gestiona el modelo de datos de los Almacenes de cada institución
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseInstitutionWarehouse extends Model implements Auditable
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
    protected $fillable = ['institution_id','warehouse_id','manage', 'main'];

    /**
     * Método que obtiene el almacén gestionado por la institucion
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo Intitution
     */
    public function institution()
    {
        return $this->belongsTo('App\Models\Institution','institution_id');
    }

    /**
     * Método que obtiene la institution que gestionan el almacén
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo Intitution
     */
    public function warehouse()
    {
        return $this->belongsTo('Modules\Warehouse\Models\Warehouse','warehouse_id')->with('country','estate','city');
    }

    public function inventaryProduct()
    {
        return $this->hasMany('Modules\Warehouse\Models\WarehouseInventaryProduct','warehouse_institution_id');
    }

    /**
     * Método que obtiene los Movimiento realizados por un almacén y/o una institución dada
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo WarehouseMovement
     */
    public function movement()
    {
        return $this->hasMany('Modules\Warehouse\Models\WarehouseMovement');
    }

}
