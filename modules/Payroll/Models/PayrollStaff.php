<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PayrollStaff
 * @brief Datos del personal
 *
 * Gestiona el modelo de datos del personal
 *
 * @author William Páez (wpaez at cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollStaff extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;
    use ModelsTrait;

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
     *
     * @var array $fillable
     */
    protected $fillable = [
        'code','first_name','last_name','payroll_nationality_id','id_number','passport','email','birthdate',
        'payroll_gender_id','emergency_contact','emergency_phone','parish_id','address'
    ];

    /**
     * PayrollPosition has many BudgetProjects.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budget_projects()
    {
        return (Module::has('Budget'))?$this->hasMany(\Modules\Budget\Models\BudgetProject::class):[];
    }

    /**
     * PayrollPosition has many BudgetCentralizedAction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budget_centralized_actions()
    {
        return (Module::has('Budget'))?$this->hasMany(\Modules\Budget\Models\BudgetCentralizedAction::class):[];
    }

    /**
     * Obtiene el nombre completo de la persona
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return string Nombre completo de la persona
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Método que obtiene la Parroquia
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return object Objeto con los registros relacionados al modelo Parish
     */
	public function parish()
    {
        return $this->belongsTo('App\Models\Parish');
    }

    /**
     * Método que obtiene el Género del personal
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return object Objeto con los registros relacionados al modelo PayrollGender
     */
	public function payroll_gender()
    {
        return $this->belongsTo(PayrollGender::class);
    }

    /**
     * Método que obtiene la nacionalidad
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return object Objeto con los registros relacionados al modelo PayrollNationality
     */
	public function payroll_nationality()
    {
        return $this->belongsTo(PayrollNationality::class);
    }

    /**
     * Método que obtiene la información socioeconómica relacionada al personal
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return object Objeto con el registro relacionados al modelo PayrollSocioeconomicInformation
     */
    public function payroll_socioecomic_information()
    {
    	return $this->hasOne(PayrollSocioeconomicInformation::class);
    }
}
