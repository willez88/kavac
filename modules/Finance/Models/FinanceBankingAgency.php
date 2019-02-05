<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class FinanceBankingAgency extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;
    
    protected $revisionCreationsEnabled = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
    	'name', 'direction', 'headquarters', 'contact_person', 'contact_email', 'finance_bank_id', 'city_id'
    ];

    /**
     * FinanceBankingAgency belongs to Bank.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bank()
    {
    	return $this->belongsTo(FinanceBank::class, 'finance_bank_id');
    }

    /**
     * FinanceBankingAgency morphs many city.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function city()
    {
    	return $this->belongsTo(\App\Models\City::class);
    }

    /**
     * FinanceBankingAgency has many FinanceBankAccount.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bank_accounts()
    {
        return $this->hasMany(FinanceBankAccount::class);
    }

    /**
     * Get all of the budget project's specific actions.
     */
    public function phones()
    {
        return $this->morphMany(\App\Models\Phone::class, 'phoneable');
    }
}
