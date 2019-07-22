<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class AssetInventoryAsset
 * @brief Datos del listado de bienes inventariados
 * 
 * Gestiona el modelo de datos de los bienes registrados en inventario
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AssetIventoryAsset extends Model implements Auditable
{
    use AuditableTrait;
	
    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['asset_condition', 'asset_status', 'asset_use_function', 'asset_id', 'asset_inventory_id'];

    /**
     * Método que obtiene registro de inventario asociada al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo AssetInventory
     */
    public function asset_inventory()
    {
        return $this->belongsTo(AssetInventory::class);
    }

    /**
     * Método que obtiene el bien asociado al registro de inventario
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo Asset
     */
    public function asset()
    {
        return $this->belongsTo(Asset::class);
    }
}
