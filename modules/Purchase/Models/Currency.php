<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Currency as BaseCurrency;

class Currency extends BaseCurrency
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

    /**
     * Currency has many PurchaseOrder.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseOrder()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = currency_id, localKey = id)
        return $this->hasMany(PurchaseOrder::class);
    }
}
