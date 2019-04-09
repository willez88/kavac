<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function finance_bank_account()
    {
    	return $this->belongsTo(FinanceBankAccount::class);
    }
}
