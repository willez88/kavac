<?php

namespace Modules\CitizenService\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;
use Module;

class CitizenServiceRegister extends Model implements Auditable
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

        'date_register', 'payroll_staff_id', 'project_name', 'team_name', 'activities', 'start_date', 'end_date', 'email', 'percent',

    ];
    protected $with = ['payrollStaff'];

    /**
     * Método que obtiene la información del trabajador asociado a un registro en ingresar un cronograma. 
     *
     * @author    Yennifer Ramirez <yramirez@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    
    public function payrollStaff()
    {
        return (Module::has('Payroll'))
               ? $this->belongsTo(\Modules\Payroll\Models\PayrollStaff::class) : [];
    }
}
