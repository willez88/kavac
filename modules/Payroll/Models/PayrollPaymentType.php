<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;
use Module;

/**
 * @class      PayrollPaymentType
 * @brief      Datos de tipos de pago
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
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = [
        'code', 'name', 'payment_periodicity', 'correlative', 'start_date', 'payment_relationship',
        'associated_records', 'accounting_account_id', 'budget_account_id'
    ];

    /**
     * Método que obtiene la cuenta contable asociada al tipo de pago
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountingAccount()
    {
        return Module::has('Accounting')
            ? $this->belongsTo(\Modules\Accounting\Models\AccountingAccount::class)
            : [];
    }

    /**
     * Método que obtiene la cuenta presupuestaria asociada al tipo de pago
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function budgetAccount()
    {
        return Module::has('Budget')
            ? $this->belongsTo(\Modules\Budget\Models\BudgetAccount::class)
            : [];
    }

    /**
     * Método que obtiene los conceptos asociados a muchos tipos de pago de nómina
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payrollConcepts()
    {
        return $this->belongsToMany(
            PayrollConcept::class,
            'payroll_concept_payment_type',
            'payroll_payment_type_id',
            'payroll_concept_id'
        );
    }

    /**
     * Método que obtiene la información de los períodos asociados al tipo de pago de nómina
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollPaymentPeriods()
    {
        return $this->hasMany(PayrollPaymentPeriod::class);
    }

    /**
     * Método que obtiene la información de las políticas de prestaciones asociadas al tipo de pago de nómina
     *
     * @author    Henry Paredes <hparedes@cenditel.gob.ve>
     *
     * @return    \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payrollBenefitsPolicies()
    {
        return $this->hasMany(PayrollBenefitsPolicy::class);
    }
}
