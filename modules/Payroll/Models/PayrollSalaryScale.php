<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//use Venturecraft\Revisionable\RevisionableTrait;
/*use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;*/

/**
 * @class CreatePayrollScales
 * @brief Datos de las escalas o niveles de un escalafón
 *
 * Gestiona el modelo de datos de las escalas o niveles de un escalafón
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollSalaryScale extends Model //implements Auditable
{
    use SoftDeletes;
    //use RevisionableTrait;
    //use AuditableTrait;

    /**
     * Establece el uso o no de bitácora de registros para este modelo
     *
     * @var boolean $revisionCreationsEnabled
     */
    protected $revisionCreationsEnabled = true;

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
    public function payroll_salary_tabulator()
    {
        return $this->hasMany(PayrollSalaryTabulator::class);
    }

    /**
     * Método que obtiene las asignaciones salariales asociadas al escalafón
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payroll_salary_assignment()
    {
        return $this->hasMany(PayrollSalaryAssignment::class);
    }

    /**
     * Método que obtiene las escalas del escalafón salarial
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payroll_scale()
    {
        return $this->hasMany(PayrollScale::class);
    }
}
