<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class FinanceBank
 * @brief Datos de las cuentas bancarias
 *
 * Gestiona el modelo de datos para las cuentas bancarias
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class FinanceBankAccount extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'opened_at'];

    protected $fillable = [
        'ccc_number', 'description', 'opened_at', 'finance_banking_agency_id', 'finance_account_type_id'
    ];

    /**
     * FinanceBankAccount belongs to FinanceBankingAgency.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function financeBankingAgency()
    {
        return $this->belongsTo(FinanceBankingAgency::class);
    }

    /**
     * FinanceBankAccount belongs to FinanceAccountType.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountType()
    {
        return $this->belongsTo(FinanceAccountType::class);
    }

    /**
     * FinanceBankAccount has many FinanceCheckBooks.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function financeCheckBooks()
    {
        return $this->hasMany(FinanceCheckBook::class);
    }
}
