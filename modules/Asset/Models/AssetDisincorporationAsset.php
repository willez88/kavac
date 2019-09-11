<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * @class AssetDisincorporationAsset
 * @brief Datos del listado de bienes registrados en una desincorporación
 *
 * Gestiona el modelo de datos de los bienes registrados en una desincorporación
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetDisincorporationAsset extends Model implements Recordable
{
    use RecordableTrait;

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['asset_id','asset_disincorporation_id'];

    /**
     * Método que obtiene la desincorporación asociada al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * AssetDisincorporation
     */
    public function assetDisincorporation()
    {
        return $this->belongsTo(AssetDisincorporation::class);
    }

    /**
     * Método que obtiene el bien asociado a la desincorporación
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo Asset
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
