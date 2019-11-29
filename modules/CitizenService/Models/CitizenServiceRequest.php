<?php

namespace Modules\CitizenService\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class CitizenService
 * @brief Datos de información de ingresar solicitud
 *
 * Gestiona el modelo de ingresar solicitud
 *
 * @author Yennifer Ramirez <yramirez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class CitizenServiceRequest extends Model implements Auditable
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
        'first_name','last_name','id_number','email', 'date',
        'payroll_sector_type_id', 'institution_name','city_id', 'municipality_id',
        'institution_address',
        'web','citizen_service_request_type_id',
        'information'

    ];

    /**
     * Obtiene todos los número telefónicos asociados a la solicitud
     *

     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function phones()
    {
        return $this->morphMany(\App\Models\Phone::class, 'phoneable');
    }
}
