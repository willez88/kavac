<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * @class CreatePayrollScales
 * @brief Datos de las escalas o niveles de un escalafón
 *
 * Gestiona el modelo de datos de las escalas o niveles de un escalafón
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                LICENCIA DE SOFTWARE CENDITEL
 *            </a>
 */
class PayrollSalaryScale extends Model implements Recordable
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
    protected $fillable = ['name', 'description', 'active'];

    /**
     * Método que obtiene los tabuladores salariales asociados al escalafón
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollSalaryTabulator()
    {
        return $this->hasMany(PayrollSalaryTabulator::class);
    }

    /**
     * Método que obtiene las asignaciones salariales asociadas al escalafón
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollSalaryAssignment()
    {
        return $this->hasMany(PayrollSalaryAssignment::class);
    }

    /**
     * Método que obtiene las escalas del escalafón salarial
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollScale()
    {
        return $this->hasMany(PayrollScale::class);
    }
}
