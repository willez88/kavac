<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PayrollOrganization
 * @brief Datos de la organización
 *
 * Gestiona el modelo de organizaciones
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollOrganization extends Model implements Auditable
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
        'name', 'start_date', 'end_date', 'payroll_sector_type_id', 'payroll_employment_id'
    ];

    /**
     * PayrollOrganization pertenece a PayrollSectorType
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollSectorType()
    {
        return $this->belongsTo(PayrollSectorType::class);
    }

    /**
     * PayrollOrganization pertenece a PayrollEmployment
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollEmployment()
    {
        return $this->belongsTo(PayrollEmployment::class);
    }
}
