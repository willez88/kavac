<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FiscalYear as BaseFiscalYear;

class FiscalYear extends BaseFiscalYear
{
    /**
     * FiscalYear has many Purchase_requirements.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchase_requirements()
    {
    	return $this->hasMany(PurchaseRequirement::class);
    }
}
