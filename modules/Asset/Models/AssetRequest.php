<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
//use Venturecraft\Revisionable\RevisionableTrait;
/*use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;*/
use App\Traits\ModelsTrait;

/**
 * @class AssetRequest
 * @brief Datos de las solicitudes de bienes institucionales
 *
 * Gestiona el modelo de datos de las solicitudes de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetRequest extends Model //implements Auditable
{
    use SoftDeletes;
    //use RevisionableTrait;
    //use AuditableTrait;
    use ModelsTrait;

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
    protected $fillable = [
        'code', 'type', 'motive', 'state', 'delivery_date', 'agent_name', 'agent_telf', 'agent_email', 'user_id'
    ];

    /**
     * Método que obtiene los bienes asociados a la solicitud
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * AssetRequestAsset
     */
    public function assetRequestAssets()
    {
        return $this->hasMany(AssetRequestAsset::class);
    }

    /**
     * Método que obtiene los eventos asociados a la solicitud
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * AssetRequestEvent
     */
    public function assetRequestEvents()
    {
        return $this->hasMany(AssetRequestEvent::class);
    }

    /**
     * Método que obtiene las prorrogas asociados a la solicitud
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * AssetRequestProrroga
     */
    public function assetRequestExtension()
    {
        return $this->hasMany(assetRequestExtension::class);
    }

    /**
     * Método que obtiene el usuario asociado al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo User
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
