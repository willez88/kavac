<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Module;

/**
 * @class AssetAsignation
 * @brief Datos de las asignaciones de los bienes institucionales
 *
 * Gestiona el modelo de datos de las asignaciones de bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetAsignation extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /**
     * Lista de atributos para la gestión de fechas
     *
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['code', 'payroll_staff_id', 'department_id', 'user_id'];

    /**
     * Método que obtiene los bienes asignados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * AssetAsignationAsset
     */
    public function assetAsignationAssets()
    {
        return $this->hasMany(AssetAsignationAsset::class);
    }

    /**
     * Método que obtiene el trabajador al que se le asigna el bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return Array|\Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * PayrollStaff
     */
    public function payrollStaff()
    {
        return (Module::has('Payroll'))
               ? $this->belongsTo(\Modules\Payroll\Models\PayrollStaff::class) : [];
    }

    /**
     * Método que obtiene el departamento donde recide el bien asignado
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return Objeto con el registro relacionado al modelo Department
     */
    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * Método que obtiene el usuario asociado al registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo User
     */
    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
