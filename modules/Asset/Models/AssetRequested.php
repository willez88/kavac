<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class AssetRequest
 * @brief Datos de las solicitudes de Bienes Institucionales
 * 
 * Gestiona el modelo de datos para las solicitudes de Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetRequested extends Model implements Auditable
{
	use AuditableTrait;
	
    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['inventary_id','asset_id','request_id'];

    /**
     * Método que obtiene la solicitud a la que pertenece el bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetRequest
     */
    public function request()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetRequest', 'request_id');
    }

    /**
     * Método que obtiene el registro de inventario al que pertenece el bien solicitado
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetInventary
     */
    public function inventary()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetInventary', 'inventary_id');
    }

    /**
     * Método que obtiene el registro del bien solicitado
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo Asset
     */
    public function asset()
    {
        return $this->belongsTo('Modules\Asset\Models\Asset', 'asset_id');
    }

}
