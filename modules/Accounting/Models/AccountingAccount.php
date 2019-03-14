<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingAccount extends Model
{
    protected $fillable = [
		'group',
		'sub_group',
		'item',
		'account',
		'first_sub_account',
		'second_sub_account',
		'denomination',
		'active',
		'inactivity_date'
	];
}
