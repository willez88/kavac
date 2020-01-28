<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Tax as BaseTax;

class Tax extends BaseTax
{
    /**
     * Currency has many PurchaseBaseBudget.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseBaseBudget()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = currency_id, localKey = id)
        return $this->hasMany(PurchaseBaseBudget::class);
    }
}
