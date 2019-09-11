<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * @class PayrollSalaryAssignmentType
 * @brief Datos de los tipos de asignaciones salariales
 *
 * Gestiona el modelo de datos para los tipos de asignaciones salariales
 *
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                LICENCIA DE SOFTWARE CENDITEL
 *            </a>
 */
class PayrollSalaryAssignmentType extends Model implements Recordable
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
    protected $fillable = ['name','description'];

    /**
     * Método que obtiene las asignaciones salariales asociadas al tipo de asignación
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollSalaryAssignment()
    {
        return $this->hasMany(PayrollSalaryAssignment::class);
    }
}
