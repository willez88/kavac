<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class      PayrollBenefitsPolicy
 * @brief      Datos de las políticas de prestaciones
 *
 * Gestiona el modelo de datos de las políticas de prestaciones
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class PayrollBenefitsPolicy extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Lista de atributos para la gestión de fechas
     * @var    array    $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var    array    $fillable
     */
    protected $fillable = [
        'name', 'start_date', 'end_date', 'benefit_days', 'minimum_number_months', 'additional_days_per_year',
        'minimum_number_years', 'additional_maximum_days_per_year', 'work_interruption_days', 'month_worked_days',
        'benfits_advance_payment', 'maximum_advance_percentage', 'number_advances_per_year', 'salary_type',
        'institution_id', 'active'
    ];

    /**
     * Lista de atributos de relacion consultados automaticamente
     * @var    array    $with
     */
    protected $with = ['institution'];

    /**
     * Método que obtiene la información de la institución asociada a la política vacacional
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }
}
