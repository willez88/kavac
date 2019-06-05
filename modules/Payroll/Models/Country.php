<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country as BaseCountry;

class Country extends BaseCountry
{
    /**
     * Country has many PayrollNationality
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payroll_nationalities()
    {
    	return $this->hasMany(PayrollNationality::class);
    }
}
