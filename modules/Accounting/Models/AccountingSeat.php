<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingSeat extends Model
{
    protected $fillable = [
    	'from_date',
    	'concept',
    	'observations',
    	'reference',
    	'tot_debit',
    	'tot_assets',
    	'generated_by_id',
    	'approved'
    ];

	public function accounting_accounts()
    {
        return $this->hasMany(AccountingSeatAccount::class);
    }
}
