<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
/*use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;*/
use App\Traits\ModelsTrait;

/**
 * @class AssetUseFunction
 * @brief Datos de las Funciones de uso
 *
 * Gestiona el modelo de datos para las funciones de uso de los bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetUseFunction extends Model //implements Auditable
{
    //use AuditableTrait;
    use ModelsTrait;

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['name'];

    /**
     * Método que obtiene los bienes asociados a una función de uso
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo Asset
     */
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
