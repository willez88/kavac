<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * @class BudgetSpecificAction
 * @brief Datos de Acciones Específicas
 *
 * Gestiona el modelo de datos para las Acciones Específicas
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class BudgetSpecificAction extends Model implements Recordable
{
    use SoftDeletes;
    use RecordableTrait;

    /** @var array Establece las relaciones por defecto que se retornan con las consultas */
    protected $with = ['specificable'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'from_date', 'to_date'];

    protected $fillable = ['from_date', 'to_date', 'code', 'name', 'description', 'active'];


    /**
     * Crea un campo para obtener el nombre de la institución
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return string Devuelve el nombre de la institución asociada a la acción específica
     */
    public function getInstitutionAttribute()
    {
        return $this->specificable->department->institution->name;
    }

    /**
     * Crea un campo para obtener el tipo de registro asociado (Proyecto o Acción Centralizada)
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return string Devuelve el tipo de registro asociado
     */
    public function getTypeAttribute()
    {
        $type = str_replace("Modules\Budget\Models\\", "", $this->specificable_type);

        return ($type === "BudgetCentralizedAction") ? "Acción Centralizada" : "Proyecto";
    }

    /**
     * Crea un campo para obtener información del código y nombre de la acción específica
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return string Devuelve el código y nombre de la acción específica
     */
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
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function subSpecificFormulations()
    {
        return $this->hasMany(BudgetSubSpecificFormulation::class, 'budget_specific_action_id');
    }
}
