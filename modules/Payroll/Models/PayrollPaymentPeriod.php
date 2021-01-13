<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class     PayrollPaymentPeriod
 * @brief     Datos de los períodos de pago de nómina
 *
 * Gestiona el modelo de períodos de pago de nómina
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PayrollPaymentPeriod extends Model implements Auditable
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
        'number', 'start_date', 'start_day', 'end_date', 'end_day', 'payment_status', 'payroll_payment_type_id'
    ];

    /**
     * Método que obtiene la información del tipo de pago asociado al período de pago de nómina
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollPaymentType()
    {
        return $this->belongsTo(PayrollPaymentType::class);
    }

    /**
     * Método que obtiene la información del registro de nómina asociado al período de pago
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payroll()
    {
        return $this->hasOne(Payroll::class);
    }
}
