<?php

/** Modelos generales de base de datos */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class Document
 * @brief Datos de los documentos
 *
 * Gestiona el modelo de datos para los documentos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class Document extends Model implements Auditable
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
        'code', 'file', 'url', 'signs', 'archive_number', 'physical_support', 'digital_support_original',
        'digital_support_signed', 'documentable_type', 'documentable_id'
    ];

    /**
     * Document morphs to models in documentable_type
     *
     * @method  documentable
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function documentable()
    {
        return $this->morphTo();
    }
}
