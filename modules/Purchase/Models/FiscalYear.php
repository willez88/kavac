<?php

namespace Modules\Purchase\Models;

use App\Models\FiscalYear as BaseFiscalYear;

class FiscalYear extends BaseFiscalYear
{
    /**
     * FiscalYear has many PurchaseRequirements.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseRequirements()
    {
        return $this->hasMany(PurchaseRequirement::class);
    }
}
