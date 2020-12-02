<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User as BaseTax;

class User extends BaseTax
{
    /**
     * Currency has many PurchasePlan.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchasePlans()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = currency_id, localKey = id)
        return $this->hasMany(PurchasePlan::class);
    }


}
