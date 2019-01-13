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

    protected $fillable = ['year', 'budget_specific_action_id'];

    /**
     * BudgetSubSpecificFormulation belongs to BudgetSpecificAction.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specific_action()
    {
    	return $this->belongsTo(BudgetSpecificAction::class);
    }
}
