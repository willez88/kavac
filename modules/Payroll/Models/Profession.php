<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Profession as BaseProfession;

class Profession extends BaseProfession
{
    /**
     * Método que obtiene las profesines asociadas a muchas informaciones profesionales del trabajador
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function payrollProfessionalInformations()
    {
        return $this->belongsToMany(PayrollProfessionalInformation::class)->withTimestamps();
    }
}
