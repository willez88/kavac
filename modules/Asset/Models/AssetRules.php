<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class AssetRules
 * @brief Modelo de datos de las reglas de bienes en inventario
 * 
 * Gestiona el modelo de datos de los cambios en las reglas por cada bien en el inventario
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AssetRules extends Model
{
    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['asset_inventary_id','min','user_id'];
}
