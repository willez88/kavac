<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Profession as BaseProfession;

class Profession extends BaseProfession
{
    /**
     * Profession has many PayrollProfessionalInformation
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payroll_professional_informations()
    {
    	return $this->hasMany(PayrollProfessionalInformation::class);
    }
}
