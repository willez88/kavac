<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class AssetUse
 * @brief Datos de las Funciones de uso
 * 
 * Gestiona el modelo de datos para las funciones de uso de los bienes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetMotiveDisincorporation extends Model implements Auditable
{
    use ModelsTrait;
    use AuditableTrait;

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['name'];

	/**
     * Método que obtiene las desincorporaciones asociadas a un motivo dado
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetDisincorporation
     */
    public function disincorporation()
    {
        return $this->hasMany('Modules\Asset\Models\AssetDisincorporation');
    }
}

