<?php
/** [descripción del namespace] */
namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PayrollEmployment
 * @brief Datos laborales del trabajador
 *
 * Gestiona el modelo de datos laborales
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollEmployment extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Lista de atributos de relacion consultados automáticamente
     * @var array $with
     */
    protected $with = ['payrollPosition', 'department'];

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
        'active', 'start_date_apn', 'start_date', 'end_date', 'institution_email', 'function_description',
        'payroll_inactivity_type_id', 'payroll_position_type_id', 'payroll_position_id', 'deparment_id',
        'payroll_staff_type_id', 'payroll_contract_type_id', 'payroll_staff_id'
    ];

    /**
     * Método que obtiene el dato laboral del trabajador que está asociada a muchas organizaciones
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollOrganizations()
    {
        return $this->hasMany(PayrollOrganization::class);
    }

    /**
     * Método que obtiene el dato laboral del trabajador asociado a un dato personal del mismo
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollStaff()
    {
        return $this->belongsTo(PayrollStaff::class);
    }

    /**
     * Método que obtiene el dato laboral del trabajador asociado a un tipo de inactividad
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollInactivityType()
    {
        return $this->belongsTo(PayrollInactivityType::class);
    }

    /**
     * Método que obtiene el dato laboral del trabajador asociado a un tipo de cargo
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollPositionType()
    {
        return $this->belongsTo(PayrollPositionType::class);
    }

    /**
     * Método que obtiene el dato laboral del trabajador asociado a un cargo
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollPosition()
    {
        return $this->belongsTo(PayrollPosition::class);
    }

    /**
     * Método que obtiene el dato laboral del trabajador asociado a un departamento
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Método que obtiene el dato laboral del trabajador asociado a un tipo de personal
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollStaffType()
    {
        return $this->belongsTo(PayrollStaffType::class);
    }

    /**
     * Método que obtiene el dato laboral del trabajador asociado a un tipo de contrato
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollContractType()
    {
        return $this->belongsTo(PayrollContractType::class);
    }
}
