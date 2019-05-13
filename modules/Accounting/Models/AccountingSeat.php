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
    /**
     * AccountingSeat has many AccountingSeatAccount.
     *
     * @author  Juan Rosas <JuanFBass17@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
	public function accounting_accounts()
    {
        return $this->hasMany(AccountingSeatAccount::class);
    }

    /**
     * AccountingSeat belongs to AccountingSeatCategory.
     *
     * @author  Juan Rosas <JuanFBass17@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function generated_by()
    {
        return $this->belongsTo(AccountingSeatCategory::class);
    }
}
