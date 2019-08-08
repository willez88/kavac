<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Country as BaseCountry;

class Country extends BaseCountry
{
    /**
     * Método que obtiene el país asociado a una nacionalidad
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function payroll_nationality()
    {
    	return $this->hasOne(PayrollNationality::class);
    }
}
