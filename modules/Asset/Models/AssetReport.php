<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class AssetReport
 * @brief Datos del historico de los reportes del modulo de bienes
 *
 * Gestiona el modelo de datos del historico de los reportes del modulo de bienes
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetReport extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /**
     * Lista de atributos para la gestión de fechas
     *
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = [
        'code', 'type_report', 'type_search', 'asset_type_id', 'asset_category_id',
        'asset_subcategory_id', 'asset_specific_category_id', 'institution_id', 'department_id', 'mes',
        'year', 'start_date', 'end_date', 'document_id', 'status'
    ];

    /**
     * Método que obtiene la información del documento asociado al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo Document
     */
    public function document()
    {
        return $this->belongsTo(\App\Models\Document::class);
    }
}
