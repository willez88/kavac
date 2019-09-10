<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

/*use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;*/

/**
 * @class AssetRequestEvent
 * @brief Datos de los eventos asociados a una solicitud
 *
 * Gestiona el modelo de datos de los eventos asociados a una solicitud
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetRequestEvent extends Model //implements Auditable
{
    //use AuditableTrait;

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['type', 'description', 'asset_request_id'];

    /**
     * Método que obtiene la solicitud asociada al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * AssetRequest
     */
    public function assetRequest()
    {
        return $this->belongsTo(AssetRequest::class);
    }
}
