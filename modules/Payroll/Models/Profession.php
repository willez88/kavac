<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Profession as BaseProfession;

class Profession extends BaseProfession
{
    /**
     * Método que obtiene la profesión asociado a una información profesional del trabajador
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function payrollProfessionalInformation()
    {
        return $this->belongsTo(PayrollProfessionalInformation::class);
    }
}
