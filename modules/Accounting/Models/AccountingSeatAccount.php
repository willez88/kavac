<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingSeatAccount extends Model
{
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
}
