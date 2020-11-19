<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class      PayrollVacationRequest
 * @brief      Datos de las solicitudes de vacaciones
 *
 * Gestiona el modelo de datos de las solicitudes de vacaciones
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class PayrollVacationRequest extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = [
        'code', 'status', 'days_requested', 'vacation_period_year', 'start_date',
        'end_date', 'payroll_staff_id', 'institution_id'
    ];

    /**
     * Lista de atributos de relacion consultados automaticamente
     * @var    array    $with
     */
    protected $with = ['institution', 'payrollStaff'];

    /**
     * Método que obtiene la información de la institución asociada a la solicitud de vacaciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * Método que obtiene la información del trabajador asociado a la solicitud de vacaciones
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollStaff()
    {
        return $this->belongsTo(PayrollStaff::class);
    }
}
