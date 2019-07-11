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

    protected $table = "payroll_staffs";

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
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return string Nombre completo de la persona
     */
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * PayrollStaff belongs to Parish
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function parish()
    {
        return $this->belongsTo(Parish::class);
    }

    /**
     * PayrollStaff belongs to PayrollGender
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function payroll_gender()
    {
        return $this->belongsTo(PayrollGender::class);
    }

    /**
     * PayrollStaff belongs to PayrollNationality
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function payroll_nationality()
    {
        return $this->belongsTo(PayrollNationality::class);
    }

    /**
     * PayrollStaff has one PayrollSocioeconomicInformation
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payroll_socioecomic_information()
    {
    	return $this->hasOne(PayrollSocioeconomicInformation::class);
    }

    /**
     * PayrollStaff has one PayrollProfessionalInformation
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payroll_professional_information()
    {
    	return $this->hasOne(PayrollProfessionalInformation::class);
    }

    /**
     * Obtiene todos los número telefónicos asociados al trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function phones()
    {
        return $this->morphMany(\App\Models\Phone::class, 'phoneable');
    }

    /**
     * PayrollStaff tiene un solo PayrollEmploymentInformation
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payroll_employment_information()
    {
    	return $this->hasOne(PayrollEmploymentInformation::class);
    }
}
