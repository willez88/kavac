<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

use Modules\Asset\Models\Asset;

/**
 * @class AssetInventary
 * @brief Datos del Inventario de Bienes
 * 
 * Gestiona el modelo de datos del Inventario de Bienes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AssetInventary extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;

    /**
     * Establece el uso o no de bitácora de registros para este modelo
     * @var boolean $revisionCreationsEnabled
     */
    protected $revisionCreationsEnabled = true;

    /**
     * Lista de atributos para la gestión de fechas
     *
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['exist','reserved','unit_value'];

    /**
     * Método que obtiene los bienes de un registro de inventario
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo Asset
     */
    public function assets()
    {
        return $this->hasOne('Modules\Asset\Models\Asset');
    }

    /**
     * Método que obtiene los bienes solicitados de un registro de inventario
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetRequest
     */
    public function assetsrequested()
    {
        return $this->hasMany('Modules\Asset\Models\AssetRequested');
    }

    /**
     *
     * @brief Método que genera un listado de elementos registrados en almacen para ser implementados en plantillas blade
     * 
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return [array] Listado de bienes institucionales en inventario
     */
    public static function template_choices()
    {
        $options = [];
        foreach (Asset::all() as $reg) {
            if($reg->inventary_id > 0)
                $options[$reg->id] = $reg->getDescription();
        }
        return $options;
    }

}
