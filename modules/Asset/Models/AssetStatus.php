<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;
use App\Traits\ModelsTrait;

/**
 * @class AssetStatus
 * @brief Datos de los Estados de uso de un bien
 *
 * Gestiona el modelo de datos de los estados de uso de los bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetStatus extends Model implements Recordable
{
    use RecordableTrait;
    use ModelsTrait;

    /**
     * Nombre de la tabla a usar en la base de datos
     *
     * @var string $table
     */
    protected $table = 'asset_status';

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['name'];

    /**
     * Método que obtiene los bienes asociados a un estatus de uso
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo Asset
     */
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
