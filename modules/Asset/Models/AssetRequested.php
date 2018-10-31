<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class AssetRequest
 * @brief Datos de las solicitudes de Bienes Institucionales
 * 
 * Gestiona el modelo de datos para las solicitudes de Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetRequested extends Model
{
    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['inventary_id','request_id'];

}
