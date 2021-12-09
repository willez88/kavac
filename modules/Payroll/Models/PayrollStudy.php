<?php
/** [descripción del namespace] */
namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PayrollStudy
 * @brief Datos de estudios
 *
 * Gestiona el modelo de datos de estudios
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollStudy extends Model implements Auditable
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
        'university_name', 'graduation_year', 'payroll_study_type_id', 'profession_id', 'payroll_professional_id'
    ];

    /**
     * Método que obtiene el dato profesional del trabajador asociado a un estudio
     *
     * @author  William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollProfessional()
    {
        return $this->belongsTo(PayrollProfessional::class);
    }
}
