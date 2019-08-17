<?php

namespace Modules\Purchase\Models;

use App\Models\City as BaseCity;

class City extends BaseCity
{
    /**
     * City has many PurchaseSuppliers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseSuppliers()
    {
        return $this->hasMany(PurchaseSupplier::class);
    }
}
