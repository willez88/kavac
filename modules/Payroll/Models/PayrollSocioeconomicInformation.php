<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PayrollSocioeconomicInformation
 * @brief Datos de información socioeconómica del trabajador
 *
 * Gestiona el modelo de información socioeconómica
 *
 * @author William Páez <wpaez@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollSocioeconomicInformation extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;
    use ModelsTrait;

    protected $table = 'payroll_socioeconomic_informations';

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
        'full_name_twosome', 'id_number_twosome', 'birthdate_twosome',
        'payroll_staff_id', 'marital_status_id',
    ];

    /**
     * Método que obtiene la información socioeconómica del trabajador asociado a una información personal del mismo
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function payroll_staff()
    {
        return $this->belongsTo(PayrollStaff::class);
    }

    /**
     * Método que obtiene la información socioeconómica del trabajador asociado a un estado civil
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function marital_status()
    {
        return $this->belongsTo(MaritalStatus::class);
    }

    /**
     * Método que obtiene la información socioeconómica del trabajador que está asociado a muchos hijos del mismo
     *
     * @author  William Páez <wpaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payroll_childrens()
    {
        return $this->hasMany(PayrollChildren::class);
    }
}
