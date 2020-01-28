<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingReportHistory extends Model
{
    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = ['report','url','currency_id','institution_id'];

    /**
     * AccountingReportHistory belongs to Currency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        // belongsTo(RelatedModel, foreignKey = currency_id, keyOnRelatedModel = id)
        return $this->belongsTo(Currency::class);
    }

    /**
     * AccountingReportHistory belongs to Institution.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institution()
    {
        // belongsTo(RelatedModel, foreignKey = institution_id, keyOnRelatedModel = id)
        return $this->belongsTo(Institution::class);
    }
    
    public function queryAccess($id)
    {
        if ($id != $this->institution_id && !auth()->user()->isAdmin()) {
            return true;
        }
        return false;
    }
}
