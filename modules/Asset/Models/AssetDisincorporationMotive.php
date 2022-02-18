<?php

namespace Modules\Asset\Models;

use App\Traits\ModelsTrait;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class AssetDisincorporationMotive
 * @brief Datos de los motivos de la desincorporación de un bien
 *
 * Gestiona el modelo de datos de los motivos de la desincorporación de un bien
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetDisincorporationMotive extends Model implements Auditable
{
    use ModelsTrait;
    use SoftDeletes;
    use AuditableTrait;

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['name'];

    /**
     * Método que obtiene las desincorporaciones asociadas a un registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * AssetDisincorporation
     */
    public function assetDisincorporations()
    {
        return $this->hasMany(AssetDisincorporation::class);
    }
}
