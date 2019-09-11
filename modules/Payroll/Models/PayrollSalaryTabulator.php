<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;

/**
 * @class CreatePayrollSalaryTabulator
 * @brief Datos de los tabuladores salariales
 *
 * Gestiona el modelo de datos de los tabuladores salariales
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                LICENCIA DE SOFTWARE CENDITEL
 *            </a>
 */
class PayrollSalaryTabulator extends Model implements Recordable
{
    use SoftDeletes;
    use RecordableTrait;

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
        'name', 'description', 'active', 'payroll_position_type_id', 'payroll_horizontal_salary_scale_id',
        'payroll_vertical_salary_scale_id'
    ];

    /**
     * Método que obtiene el tipo de cargo al que pertenece el tabulador
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollPositionType()
    {
        return $this->belongsTo(PayrollPositionType::class);
    }

    /**
     * Método que obtiene el escalafón vertical asociado al tabulador
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollVerticalSalaryScale()
    {
        return $this->belongsTo(PayrollSalaryScale::class);
    }

    /**
     * Método que obtine el escalafón horizontal asociado al tabulador
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollHorizontalSalaryScale()
    {
        return $this->belongsTo(PayrollSalaryScale::class);
    }
}
