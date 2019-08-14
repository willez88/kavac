<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

use Module;

/**
 * @class BudgetProject
 * @brief Datos de Proyectos
 *
 * Gestiona el modelo de datos para los Proyectos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class BudgetProject extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;
    
    protected $revisionCreationsEnabled = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'onapre_code', 'active', 'department_id', 'payroll_position_id', 'payroll_staff_id'
    ];

    /**
     * BudgetProject belongs to Department.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * BudgetProject belongs to PayrollPosition.
     *
     * @return array|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payroll_position()
    {
        return (Module::has('Payroll'))
               ? $this->belongsTo(\Modules\Payroll\Models\PayrollPosition::class) : [];
    }

    /**
     * BudgetProject belongs to PayrollStaff.
     *
     * @return array|\Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payroll_staff()
    {
        return (Module::has('Payroll'))
               ? $this->belongsTo(\Modules\Payroll\Models\PayrollStaff::class) : [];
    }

    /**
     * Obtiene información de las acciones específicas asociadas a un proyecto
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function specific_actions()
    {
        return $this->morphMany(BudgetSpecificAction::class, 'specificable');
    }
}
