<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PayrollLanguage
 * @brief Datos de idiomas
 *
 * Gestiona el modelo de idiomas
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollLanguage extends Model implements Auditable
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
     *
     * @var array $fillable
     */
    protected $fillable = [
        'name', 'acronym'
    ];

    /**
     * Método que obtiene los idiomas que están asociados a muchas informaciones profesionales del trabajador
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payrollProfessionalInformations()
    {
        return $this->belongsToMany(
            PayrollProfessionalInformation::class,
            'payroll_language_payroll_professional',
            'payroll_language_id',
            'payroll_professional_information_id'
        )->withTimestamps();
    }
}
