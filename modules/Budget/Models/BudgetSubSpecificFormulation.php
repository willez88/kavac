<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class BudgetSubSpecificFormulation extends Model implements Auditable
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
        'code', 'year', 'total_formulated', 'assigned', 'budget_specific_action_id', 'currencies_id'
    ];

    /**
     * BudgetSubSpecificFormulation belongs to BudgetSpecificAction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specific_action()
    {
    	return $this->belongsTo(BudgetSpecificAction::class);
    }

    /**
     * BudgetSubSpecificFormulation belongs to Currency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(\App\Models\Currency::class);
    }

    /**
     * BudgetSubSpecificFormulation has many BudgetAccountOpen.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function account_opens()
    {
        return $this->hasMany(BudgetAccountOpen::class);
    }
}
