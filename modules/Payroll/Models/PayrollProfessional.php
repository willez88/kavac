<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PayrollProfessional
 * @brief Datos de la información profesional del trabajador
 *
 * Gestiona el modelo de información profesional del trabajador
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollProfessional extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = [
        'instruction_degree_name', 'is_student', 'study_program_name', 'class_schedule',
        'payroll_staff_id', 'payroll_instruction_degree_id', 'payroll_study_type_id',
    ];

    /**
     * Método que obtiene la información profesional del trabajador asociado a una información personal del mismo
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollStaff()
    {
        return $this->belongsTo(PayrollStaff::class);
    }

    /**
     * Método que obtiene la información profesional del trabajador asociado a un grado de instrucción
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollInstructionDegree()
    {
        return $this->belongsTo(PayrollInstructionDegree::class);
    }

    /**
     * Método que obtiene la información profesional del trabajador asociado a un tipo de estudio
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollStudyType()
    {
        return $this->belongsTo(PayrollStudyType::class);
    }

    /**
     * Método que obtiene las informacines profesionales del trabajador asociadas a muchas profesiones
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function professions()
    {
        return $this->belongsToMany(Profession::class)->withTimestamps();
    }

    /**
     * Método que obtiene los datos profesionales del trabajador asociados a muchos idiomas
     *
     * @author    William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payrollLanguages()
    {
        return $this->belongsToMany(
            PayrollLanguage::class,
            'payroll_lang_prof',
            'payroll_prof_id',
            'payroll_lang_id',
        )->withPivot('payroll_language_level_id')->withTimestamps();
    }

    /**
     * Método que obtiene el horario de clase asociado a un dato profesional del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payrollClassSchedule()
    {
        return $this->hasOne(PayrollClassSchedule::class);
    }

    /**
     * Método que obtiene el curso asociado a un dato profesional del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payrollCourse()
    {
        return $this->hasOne(PayrollCourse::class);
    }

    /**
     * Método que obtiene el reconocimiento asociado a un dato profesional del trabajador
     *
     * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payrollAcknowledgment()
    {
        return $this->hasOne(PayrollAcknowledgment::class);
    }
}
