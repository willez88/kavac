<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PayrollInstructionDegree
 * @brief Datos de grado de instrucción
 *
 * Gestiona el modelo de grados de instruccíón
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollInstructionDegree extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Establece el uso o no de bitácora de registros para este modelo
     * @var boolean $revisionCreationsEnabled
     */
    protected $revisionCreationsEnabled = true;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name', 'description'
    ];

    /**
     * Método que obtiene el grado de instrucción asociado a muchas informaciones profesionales del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollProfessionalInformations()
    {
        return $this->hasMany(PayrollProfessionalInformation::class);
    }
}
