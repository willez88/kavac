<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class AssetRequest
 * @brief Datos de las solicitudes de Bienes Institucionales
 * 
 * Gestiona el modelo de datos para las solicitudes de Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetRequest extends Model implements Auditable
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
    protected $fillable = ['type','motive', 'state','delivery_date','agent_name','agent_telf','agent_email'];

    /**
     * Método que obtiene los bienes solicitados
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetRequested
     */
    public function assets()
    {
        return $this->hasMany('Modules\Asset\Models\AssetRequested', 'request_id');
    }

    public function events()
    {
        return $this->hasMany('Modules\Asset\Models\AssetRequestEvent');
    }

    public function prorroga()
    {
        return $this->hasMany('Modules\Asset\Models\AssetRequestProrroga');
    }
}
