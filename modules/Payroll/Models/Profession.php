<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Profession as BaseProfession;

class Profession extends BaseProfession
{
    /**
     * Método que obtiene la profesión que está asociada a muchas informaciones profesionales del trabajador
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payroll_professional_informations()
    {
    	return $this->hasMany(PayrollProfessionalInformation::class);
    }
}
