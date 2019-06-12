<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class PayrollAssignmentType
 * @brief Datos de los tipos de asignaciones de nómina
 * 
 * Gestiona el modelo de datos para los tipos de asignaciones de nómina
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class PayrollAssignmentType extends Model implements Auditable
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
     *
     * @var array $fillable
     */
    protected $fillable = ['name','description'];
}
