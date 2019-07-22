<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class AssetRules
 * @brief Modelo de datos de las reglas de bienes en inventario
 * 
 * Gestiona el modelo de datos de los cambios en las reglas por cada bien en el inventario
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AssetRules extends Model implements Auditable
{
	use AuditableTrait;
	
    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['asset_inventory_id', 'min', 'user_id'];

    /**
     * Método que obtiene el registro de inventario asociado al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo AssetInventory
     */
    public function asset_inventory()
    {
        return $this->belongsTo(AssetInventory::class);
    }

    /**
     * Método que obtiene el usuario asociado al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo User
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
