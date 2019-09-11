<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * @class AssetInventory
 * @brief Datos del inventario de bienes institucionales
 *
 * Gestiona el modelo de datos del inventario de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetInventory extends Model implements Recordable
{
    use SoftDeletes;
    use RecordableTrait;

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
    protected $fillable = ['code', 'registered', 'assigned', 'disincorporated', 'reserved'];

    /**
     * Método que obtiene los bienes asociados al registro de inventario
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * AssetRequestAsset
     */
    public function assetInventoryAssets()
    {
        return $this->hasMany(AssetInventoryAsset::class);
    }
}
