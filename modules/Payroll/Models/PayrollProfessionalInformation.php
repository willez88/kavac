<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PayrollProfessionalInformation
 * @brief Datos de la información profesional del trabajador
 *
 * Gestiona el modelo de información profesional del trabajador
 *
 * @author William Páez <wpaez at cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollProfessionalInformation extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;
    use ModelsTrait;

    protected $table = 'payroll_professional_informations';

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
        'payroll_instruction_degree_id', 'profession_id', 'instruction_degree_name', 'is_student',
        'payroll_study_type_id', 'study_program_name', 'class_schedule',
        'payroll_language_id', 'payroll_language_level_id', 'payroll_staff_id'
    ];

    /**
     * PayrollProfessionalInformation belongs to PayrollStaff
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function payroll_staff()
    {
        return $this->belongsTo(PayrollStaff::class);
    }

    /**
     * PayrollProfessionalInformation belongs to PayrollInstructionDegree
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function payroll_instruction_degree()
    {
        return $this->belongsTo(PayrollInstructionDegree::class);
    }

    /**
     * PayrollProfessionalInformation belongs to Profession
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function profession()
    {
        return $this->belongsTo(Profession::class);
    }

    /**
     * PayrollProfessionalInformation belongs to PayrollStudyType
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function payroll_study_type()
    {
        return $this->belongsTo(PayrollStudyType::class);
    }

    /**
     * PayrollProfessionalInformation belongs to PayrollLanguage
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function payroll_language()
    {
        return $this->belongsTo(PayrollLanguage::class);
    }

    /**
     * PayrollProfessionalInformation belongs to PayrollLanguageLevel
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function payroll_language_level()
    {
        return $this->belongsTo(PayrollLanguageLevel::class);
    }
}
