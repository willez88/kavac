<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;
use App\Models\User;

/**
 * @class AssetDisincorporation
 * @brief Datos de las desincorporaciones de los bienes institucionales
 *
 * Gestiona el modelo de datos de las desincorporaciones de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetDisincorporation extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

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
    protected $fillable = ['code', 'asset_disincorporation_motive_id', 'date', 'observation', 'user_id', 'institution_id'];

    /**
    * Método que obtiene los bienes desincorporados
    *
    * @author Henry Paredes <hparedes@cenditel.gob.ve>
    * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
    * AssetDisincorporationAsset
    */
    public function assetDisincorporationAssets()
    {
        return $this->hasMany(AssetDisincorporationAsset::class);
    }

    /**
     * Método que obtiene el motivo de la desincorporacion del bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * AssetDisincorporationMotive
     */
    public function assetDisincorporationMotive()
    {
        return $this->belongsTo(AssetDisincorporationMotive::class);
    }

    /**
     * Método que obtiene el usuario asociado al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
