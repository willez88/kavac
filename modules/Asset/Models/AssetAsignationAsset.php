<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class AssetAsignationAsset
 * @brief Datos de los Bienes que han sido asignados
 * 
 * Gestiona el modelo de datos de los Bienes Asignados
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetAsignationAsset extends Model implements Auditable
{
    use AuditableTrait;
	
    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['asset_id','asignation_id'];

    /**
     * Método que obtiene la asignación a la que pertenecen el bien selecionado
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetAsignation
     */
    public function asignation()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetAsignation', 'asignation_id');
    }

    /**
     * Método que obtiene el registro de los bienes selecionados para la asignación
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo Asset
     */
    public function asset()
    {
        return $this->belongsTo('Modules\Asset\Models\Asset', 'asset_id');
    }
}
