<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingAccount extends Model
{
    protected $fillable = [
		'group',
		'subgroup',
		'item',
		'generic',
		'specific',
		'subspecific',
		'denomination',
		'active',
		'inactivity_date'
	];

}
