<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PayrollEmploymentInformation
 * @brief Datos de información laboral
 *
 * Gestiona el modelo de información laboral
 *
 * @author William Páez <wpaez at cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollEmploymentInformation extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;
    use ModelsTrait;

    protected $table = 'payroll_employment_informations';

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
        'active', 'payroll_inactivity_type', 'start_date_apn', 'start_date', 'end_date', 'institution_email',
        'function_description', 'payroll_position_type_id', 'payroll_position_id', 'deparment_id',
        'payroll_staff_type_id', 'payroll_contract_type_id', 'payroll_staff_id'
    ];

    /**
     * PayrollEmploymentInformation tiene muchos PayrollOrganization
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payroll_organizations()
    {
        return $this->hasMany(PayrollOrganization::class);
    }

    /**
     * PayrollEmploymentInformation pertenece a PayrollStaff
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function payroll_staff()
    {
        return $this->belongsTo(PayrollStaff::class);
    }
}
