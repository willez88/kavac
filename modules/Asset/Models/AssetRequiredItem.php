<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * @class AssetRequiredItem
 * @brief Datos de los campos requeridos de un bien
 *
 * Gestiona el modelo de datos de los campos requeridos de un bien
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetRequiredItem extends Model implements Recordable
{
    use RecordableTrait;

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['use_function', 'serial', 'marca', 'model', 'address', 'asset_specific_category_id'];

    /**
     * Método que obtiene la categoria del bien asociada a los requerimentos
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * AssetSpecificCategory
     */
    public function assetSpecificCategory()
    {
        return $this->belongsTo(AssetSpecificCategory::class);
    }
}
