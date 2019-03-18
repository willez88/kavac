<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class BudgetModification extends Model implements Auditable
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
    protected $dates = ['deleted_at', 'approved_at'];

    protected $fillable = ['approved_at', 'code', 'type', 'description', 'document', 'institution_id', 'document_status_id'];

    /**
     * BudgetModification has many BudgetModificacionAccounts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budget_modificacion_accounts()
    {
    	return $this->hasMany(BudgetModificacionAccount::class);
    }

    /**
     * BudgetModifications belongs to Institution.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institution()
    {
        return $this->belongsTo(\App\Models\Institution::class);
    }

    /**
     * BudgetModifications belongs to DocumentStatus.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document_status()
    {
        return $this->belongsTo(\App\Models\DocumentStatus::class);
    }
}
