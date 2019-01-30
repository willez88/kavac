<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class BudgetSpecificAction
 * @brief Datos de Acciones Específicas
 * 
 * Gestiona el modelo de datos para las Acciones Específicas
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class BudgetSpecificAction extends Model implements Auditable
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
    protected $dates = ['deleted_at', 'from_date', 'to_date'];

    protected $fillable = ['from_date', 'to_date', 'code', 'name', 'description', 'active'];

    public function getInstitutionAttribute()
    {
        return $this->specificable->department->institution->name;
    }

    public function getTypeAttribute()
    {
        $type = str_replace("Modules\Budget\Models\\", "", $this->specificable_type);

        return ($type === "BudgetCentralizedAction") ? "Acción Centralizada" : "Proyecto";
    }

    public function getDescriptionAttribute()
    {
        return "{$this->code} - {$this->name}";
    }

    /**
     * Get all of the owning specificable models.
     */
    public function specificable()
    {
        return $this->morphTo();
    }

    /**
     * BudgetSpecificAction has many BudgetSubSpecificFormulation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sub_specific_formulations()
    {
        return $this->hasMany(BudgetSubSpecificFormulation::class, 'budget_specific_action_id');
    }
}
