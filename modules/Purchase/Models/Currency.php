<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Currency as BaseCurrency;

class Currency extends BaseCurrency
{
    /**
     * Currency has many BaseBudget.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function baseBudget()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = currency_id, localKey = id)
        return $this->hasMany(BaseBudget::class);
    }
}
