<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PayrollStudyType
 * @brief Datos de tipos de estudio
 *
 * Gestiona el modelo de tipos de estudio
 *
 * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollStudyType extends Model implements Auditable
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
        'name', 'description'
    ];

    /**
     * Método que obtiene el tipo de estudio asociado a muchas informaciones profesionales
     *
     * @author William Páez <wpaez@cenditel.gob.ve> | <paez.william8@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollProfessionals()
    {
        return $this->hasMany(PayrollProfessional::class);
    }
}
