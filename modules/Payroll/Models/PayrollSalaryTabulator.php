<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PayrollSalaryTabulator
 * @brief Datos de los tabuladores salariales
 *
 * Gestiona el modelo de datos de los tabuladores salariales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollSalaryTabulator extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

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
        'code', 'name', 'description', 'active', 'payroll_staff_type_id', 'payroll_horizontal_salary_scale_id',
        'payroll_vertical_salary_scale_id', 'institution_id', 'currency_id'
    ];

    /**
     * Método que obtiene el tipo de personal al que pertenece el tabulador
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollStaffType()
    {
        return $this->belongsTo(PayrollStaffType::class);
    }

    /**
     * Método que obtiene el escalafón vertical asociado al tabulador
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollVerticalSalaryScale()
    {
        return $this->belongsTo(PayrollSalaryScale::class);
    }

    /**
     * Método que obtine el escalafón horizontal asociado al tabulador
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollHorizontalSalaryScale()
    {
        return $this->belongsTo(PayrollSalaryScale::class);
    }

    /**
     * Método que obtiene las escalas asociadas al tabulador salarial
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollSalaryTabulatorScales()
    {
        return $this->hasMany(PayrollSalaryTabulatorScale::class);
    }
}
