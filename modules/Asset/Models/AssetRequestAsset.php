<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * @class AssetRequestAsset
 * @brief Datos de los bienes institucionales solicitados
 *
 * Gestiona el modelo de datos de los bienes solicitados
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetRequestAsset extends Model implements Recordable
{
    use RecordableTrait;

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['asset_id', 'asset_request_id'];

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

    /**
     * Método que obtiene el bien asociado al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo Asset
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
