<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class AssetDisincorporationAsset
 * @brief Datos de los Bienes que han sido desincorporados
 * 
 * Gestiona el modelo de datos de los Bienes Desincorporados
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */


class AssetDisincorporationAsset extends Model implements Auditable
{
    use AuditableTrait;
	
    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['asset_id','disincorporation_id'];

    /**
     * Método que obtiene la desincorporación a la que pertenece el bien selecionado
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetDisincorporation
     */
    public function disincorporation()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetDisincorporation', 'disincorporation_id');
    }

    /**
     * Método que obtiene el registro de los bienes selecionados para la desincorporación
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo Asset
     */
    public function asset()
    {
        return $this->belongsTo('Modules\Asset\Models\Asset', 'asset_id');
    }
}
