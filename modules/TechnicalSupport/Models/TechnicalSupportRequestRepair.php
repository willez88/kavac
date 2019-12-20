<?php

namespace Modules\TechnicalSupport\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class TechnicalSupportRequestRepair
 * @brief Datos de las solicitudes de reparación de bienes institucionales.
 *
 * Gestiona el modelo de datos de las solicitudes de reparación de bienes institucionales.
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class TechnicalSupportRequestRepair extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

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
    protected $fillable = ['state', 'user_id'];

    /**
     * Método que obtiene el usuario que genera la solicitud de reparación
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo User
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }

    /**
     * Método que obtiene los bienes solicitados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * AssetRequestAsset
     */
    public function technicalSupportRequestRepairAssets()
    {
        return $this->hasMany(TechnicalSupportRequestRepairAsset::class);
    }

    /**
     * Método que obtiene la información de la reparación asociada a la solicitud
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne Objeto con el registro relacionado al modelo
     * TechnicalSupportRepair
     */
    public function technicalSupportRepair()
    {
        return $this->hasOne(TechnicalSupportRepair::class);
    }
}
