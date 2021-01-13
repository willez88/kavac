<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class      PayrollSalaryTabulator
 * @brief      Datos de los tabuladores salariales
 *
 * Gestiona el modelo de datos de los tabuladores salariales
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollSalaryTabulator extends Model implements Auditable
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
        'code', 'name', 'description', 'active', 'payroll_salary_tabulator_type',
        'payroll_horizontal_salary_scale_id', 'payroll_vertical_salary_scale_id',
        'institution_id', 'currency_id'
    ];

    /**
     * Método que obtiene la información de los tipos de personal asociados al tabulador
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payrollStaffTypes()
    {
        return $this->belongsToMany(PayrollStaffType::class);
    }

    /**
     * Método que obtiene la información del escalafón vertical asociado al tabulador
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollVerticalSalaryScale()
    {
        return $this->belongsTo(PayrollSalaryScale::class);
    }

    /**
     * Método que obtine la información del escalafón horizontal asociado al tabulador
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollHorizontalSalaryScale()
    {
        return $this->belongsTo(PayrollSalaryScale::class);
    }

    /**
     * Método que obtiene la información del las escalas asociadas al tabulador salarial
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollSalaryTabulatorScales()
    {
        return $this->hasMany(PayrollSalaryTabulatorScale::class);
    }

    /**
     * Método que obtiene la información del la institución asociada al tabulador salarial
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institution()
    {
        return $this->belongsTo(\App\Models\Institution::class);
    }

    /**
     * Método que obtiene la información del la moneda asociada al tabulador salarial
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(\App\Models\Currency::class);
    }

    /**
     * Método que obtiene la información de los conceptos asociados al tabulador salarial
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollConcepts()
    {
        return $this->hasMany(PayrollConcept::class);
    }
}
