<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Currency as BaseCurrency;

class Currency extends BaseCurrency
{
    /**
     * Currency has one AccountingEntry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function accountingEntry()
    {
        // hasOne(RelatedModel, foreignKeyOnRelatedModel = currency_id, localKey = id)
        return $this->hasOne(AccountingEntry::class);
    }

    /**
     * Currency has many AccountingReportHistory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accountingReportHistory()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = currency_id, localKey = id)
        return $this->hasMany(AccountingReportHitory::class);
    }
}
