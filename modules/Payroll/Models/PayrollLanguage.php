<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class      PayrollLanguage
 * @brief      Datos de idiomas
 *
 * Gestiona el modelo de idiomas
 *
 * @author     William Páez <wpaez@cenditel.gob.ve>
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
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
     * @var array $fillable
     */
    protected $fillable = [
        'name', 'acronym'
    ];

    /**
     * Método que obtiene los idiomas asociados a muchas informaciones profesionales del trabajador
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payrollProfessionals()
    {
        return $this->belongsToMany(
            PayrollProfessional::class,
            'payroll_language_language_level_professional',
            'payroll_language_id',
            'payroll_professional_id'
        )->withPivot('payroll_language_level_id')->withTimestamps();
    }

    /**
     * Método que obtiene los niveles de idioma asociados a muchas informaciones profesionales del trabajadr
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payrollLanguageLevels()
    {
        return $this->belongsToMany(
            PayrollLanguageLevel::class,
            'payroll_language_language_level_professional',
            'payroll_language_id',
            'payroll_language_level_id'
        )->withPivot('payroll_professional_id')->withTimestamps();
    }

    /**
     * Obtiene información de las opciones asignadas asociadas a un lenguaje
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payrollConceptAssignOptions()
    {
        return $this->morphMany(PayrollConceptAssignOption::class, 'assignable');
    }
}
