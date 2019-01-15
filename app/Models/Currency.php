<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Currency extends Model implements Auditable
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
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['symbol', 'name', 'country_id', 'default'];

    /**
     * Currency belongs to Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
    	return $this->belongsTo(Country::class);
    }

    /**
     * Department has many BudgetProjects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budget_sub_specific_formulations()
    {
        return (Module::has('Budget')) 
               ? $this->hasMany(\Modules\Budget\Models\BudgetSubSpecificFormulation::class) 
               : [];
    }
}
