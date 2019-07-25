<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class AssetReport
 * @brief Datos del historico de los reportes del modulo de bienes
 * 
 * Gestiona el modelo de datos del historico de los reportes del modulo de bienes
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AssetReport extends Model implements Auditable
{
    use AuditableTrait;
	
    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['code', 'type_report', 'type_search', 'asset_type_id', 'asset_category_id', 'asset_subcategory_id', 'asset_specific_category_id', 'institution_id', 'department_id', 'mes', 'year', 'start_date', 'end_date'];
}
