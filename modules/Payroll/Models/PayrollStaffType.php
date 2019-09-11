<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;
use App\Traits\ModelsTrait;

/**
 * @class StaffType
 * @brief Datos del tipo de personal
 *
 * Gestiona el modelo de datos para el tipo de personal
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PayrollStaffType extends Model implements Recordable
{
    use SoftDeletes;
    use RecordableTrait;
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
        'name','description',
    ];

    /**
     * Método que obtiene el tipo de personal asociado a muchas informaciones laborales
     *
     * @author William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollEmploymentInformations()
    {
        return $this->hasMany(PayrollEmploymentInformation::class);
    }
}
