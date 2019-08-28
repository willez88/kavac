<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class AssetAsignationAsset
 * @brief Datos del listado de bienes registrados en una asignación
 *
 * Gestiona el modelo de datos de los bienes registados en una asignación
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetAsignationAsset extends Model implements Auditable
{
    use AuditableTrait;
    
    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['asset_id', 'asset_asignation_id'];

    /**
     * Método que obtiene la asignación asociada al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * AssetAsignation
     */
    public function assetAsignation()
    {
        return $this->belongsTo(AssetAsignation::class);
    }

    /**
     * Método que obtiene el bien asociado a la asignación
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo Asset
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
