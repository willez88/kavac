<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Module;

/**
 * @class WarehouseRequest
 * @brief Datos de las solicitudes de los productos del almacén
 *
 * Gestiona el modelo de datos para las solicitudes de los productos del almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseRequest extends Model implements Auditable
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
    protected $fillable = [
        'code', 'state', 'observations', 'delivered', 'delivery_date', 'motive',
        'budget_specific_action_id', 'department_id', 'payroll_staff_id'
    ];

    /**
     * Método que obtiene el departamento o dependencia que realiza la solicitud
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * Department
     */
    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class);
    }

    /**
     * Método que obtiene la acción Específica
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return Array|\Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     *         BudgetSpecificAction
     */
    public function budgetSpecificAction()
    {
        return (Module::has('Budget'))
               ? $this->belongsTo(\Modules\Budget\Models\BudgetSpecificAction::class) : [];
    }

    /**
     * Método que obtiene el trabajador asociado a la solicitud
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return Array|\Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     *         PayrollStaff
     */
    public function payrollStaff()
    {
        return (Module::has('Payroll'))
               ? $this->belongsTo(\Modules\Payroll\Models\PayrollStaff::class) : [];
    }

    /**
     * Método que obtiene los productos asociados a la solicitud
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     *         WarehouseInventoryProductRequest
     */
    public function warehouseInventoryProductRequests()
    {
        return $this->hasMany(WarehouseInventoryProductRequest::class);
    }
}
