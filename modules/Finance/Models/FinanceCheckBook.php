<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class FinanceCheckBook
 * @brief Datos de las chequeras
 * 
 * Gestiona el modelo de datos para las chequeras
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class FinanceCheckBook extends Model implements Auditable
{
	use SoftDeletes;
    use AuditableTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = ['code', 'number', 'used', 'annulled', 'finance_bank_account_id'];

    /**
     * FinanceCheckBook belongs to Finance_bank_accounts.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function finance_bank_account()
    {
    	return $this->belongsTo(FinanceBankAccount::class);
    }
}
