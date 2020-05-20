<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PayrollPaymentType
 * @brief Datos de tipos de pago
 *
 * Gestiona el modelo de tipos de pago
 *
 * @author     Henry Paredes <hparedes@cenditel.gob.ve>
 * @license    <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                 LICENCIA DE SOFTWARE CENDITEL
 *             </a>
 */
class PayrollPaymentType extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

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
        'code', 'name', 'payment_periodicity', 'correlative', 'start_date', 'payment_relationship',
        'accounting_account_id'
    ];

    /**
     * Método que obtiene la cuenta contable asociada al tipo de pago
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado
     * al modelo AccountingAccount
     */
    public function accountingAccount()
    {
        return Module::has('Accounting')
            ? $this->belongsTo(\Modules\Accounting\Models\AccountingAccount::class)
            : [];
    }
}
