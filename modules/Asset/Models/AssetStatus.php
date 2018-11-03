<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ModelsTrait;

/**
 * @class AssetStatus
 * @brief Datos de los Estados de uso de un bien
 * 
 * Gestiona el modelo de datos para los estados de uso de los bienes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetStatus extends Model
{
    use ModelsTrait;

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['name'];

    /**
     * Método que obtiene los bienes de una condicion fisica
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo Asset
     */
    public function assets()
    {
        return $this->hasMany('Modules\Asset\Models\Asset');
    }
}

