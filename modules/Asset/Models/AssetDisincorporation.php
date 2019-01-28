<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class AssetDisincorṕoration
 * @brief Datos de las Asignaciones de Bienes Institucionales
 * 
 * Gestiona el modelo de datos para las asignaciones de Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetDisincorporation extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use ModelsTrait;
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
    protected $fillable = ['motive_id', 'date', 'observation'];

     /**
     * Método que obtiene el tipo al que pertenece el bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetCategory
     */
    public function asset()
    {
        return $this->belongsTo('Modules\Asset\Models\Asset', 'asset_id');
    }

    /**
     * Método que obtiene el motivo de la desincorporacion del bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetCategory
     */
    public function motive()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetMotiveDisincorporation', 'motive_id');
    }
}
