<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class BudgetModificationAccount extends Model implements Auditable
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

    protected $fillable = ['amount', 'operation', 'budget_sub_specific_formulation_id', 'budget_account_id', 'budget_modification_id'];

    /**
     * BudgetModificationAccount belongs to BudgetModification.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function budget_modification()
    {
    	return $this->belongsTo(BudgetModification::class);
    }

    /**
     * BudgetModificationAccount belongs to BudgetAccount.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function budget_account()
    {
    	return $this->belongsTo(BudgetAccount::class);
    }

    /**
     * BudgetModificationAccount belongs to BudgetSubSpecificFormulation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function budget_sub_specific_formulation()
    {
    	return $this->belongsTo(BudgetSubSpecificFormulation::class);
    }
}
