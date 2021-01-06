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
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
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
        'end_date', 'status_parameters', 'payroll_staff_id', 'institution_id'
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

    /**
     * Método que obtiene las solicitudes de vacaciones registradas según la fecha y/o trabajador
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @param     string    $startDate         Fecha de inicio
     * @param     string    $endDate           Fecha de culminación
     * @param     string    $payrollStaffId    Identificador único del trabajador
     *
     * @return    object                       Objeto con los registros a mostrar
     */
    public function scopeSearchPayrollVacationRequest($query, $startDate, $endDate, $payrollStaffId)
    {
        if ($startDate != "") {
            if ($endDate != "") {
                if ($payrollStaffId != "") {
                    return $query->whereDate('start_date', '>=', $startDate)
                                 ->whereDate('end_date', '=<', $endDate)
                                 ->where('payroll_staff_id', $payrollStaffId);
                }
                return $query->whereDate('start_date', '>=', $startDate)
                                 ->whereDate('end_date', '=<', $endDate);
            }
            if ($payrollStaffId != "") {
                return $query->whereDate('start_date', '>=', $startDate)
                             ->where('payroll_staff_id', $payrollStaffId);
            }
            return $query->whereDate('start_date', '>=', $startDate);
        }
        if ($endDate != "") {
            if ($payrollStaffId != "") {
                return $query->whereDate('end_date', '=<', $endDate)
                             ->where('payroll_staff_id', $payrollStaffId);
            }
            return $query->whereDate('end_date', '=<', $endDate);
        }
        if ($payrollStaffId != "") {
            return $query->where('payroll_staff_id', $payrollStaffId);
        }
    }
}
