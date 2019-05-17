<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class AccountingSeatAccount extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;
    
    protected $fillable = [
    	'accounting_seat_id',
    	'accounting_account_id',
    	'budget_account_id',
    	'debit',
    	'assets'
    ];

    public function seating()
    {
        return $this->belongsTo(AccountingSeat::class);
    }
    public function account()
    {
        return $this->belongsTo(AccountingAccount::class,'accounting_account_id');
    }
}
