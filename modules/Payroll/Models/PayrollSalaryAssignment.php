<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class PayrollSalaryAssignment
 * @brief Datos de las asignaciones salariales
 * 
 * Gestiona el modelo de datos para las asignaciones salariales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollSalaryAssignment extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;

    /**
     * Establece el uso o no de bitácora de registros para este modelo
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
    protected $fillable = ['name','description', 'active', 'incidence', 'incidence_type', 'payroll_position_type_id', 'payroll_salary_assignment_type_id', 'payroll_salary_scale_id'];

    /**
     * Método que obtiene el tipo de cargo asociado a la asignación salarial
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payroll_postition_type()
    {
    	return $this->belongsTo(PayrollPostitionType::class);
    }

    /**
     * Método que obtiene el tipo de asignación salarial
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payroll_salary_assignment_type()
    {
    	return $this->belongsTo(PayrollSalaryAssignmentType::class);
    }

    /**
     * Método que obtiene el escalafón salarial asociado a la asignación
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payroll_salary_scale()
    {
        return $this->belongsTo(PayrollSalaryScale::class);
    }
}
