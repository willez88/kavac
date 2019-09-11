<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

class AccountingSeatAccount extends Model implements Recordable
{
    use SoftDeletes;
    use RecordableTrait;

    protected $fillable = [
        'accounting_seat_id',
        'accounting_account_id',
        'debit',
        'assets'
    ];

    public function seating()
    {
        return $this->belongsTo(AccountingSeat::class, 'accounting_seat_id');
    }
    public function account()
    {
        return $this->belongsTo(AccountingAccount::class, 'accounting_account_id');
    }
}
