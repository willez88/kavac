<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class BudgetCentralizedAction extends Model implements Auditable
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
    	'name', 'code', 'custom_date', 'active', 'department_id', 'payroll_position_id', 'payroll_staff_id'
    ];

    /**
     * BudgetProject belongs to Department.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
    	return $this->belongsTo(\App\Models\Department::class);
    }

    /**
     * BudgetProject belongs to PayrollPosition.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payroll_position()
    {
    	return $this->belongsTo(\Modules\Payroll\Models\PayrollPosition::class);
    }

    /**
     * BudgetProject belongs to PayrollStaff.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payroll_staff()
    {
    	return $this->belongsTo(\Modules\Payroll\Models\PayrollStaff::class);
    }

    /**
     * Get all of the budget centralized action's specific actions.
     */
    public function specific_actions()
    {
        return $this->morphMany(BudgetSpecificAction::class, 'specificable');
    }

    /**
     * Construye un arreglo de elementos para usar en plantillas blade
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return [array] Arreglo con los registros
     */
    public static function template_choices($filters = [])
    {
        $records = self::where('active', true)->get();
        if ($filters) {
            foreach ($filters as $key => $value) {
                $records = $records->where($key, $value);
            }
            $records = $records->get();
        }
        $options = [];
        foreach ($records as $rec) {
            $options[$rec->id] = $rec->code . " - " . $rec->name;
        }
        return $options;
    }
}
