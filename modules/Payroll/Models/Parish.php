<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Parish as BaseParish;

class Parish extends BaseParish
{
    /**
     * Método que obtiene la parroquia relacionada al personal
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return object Objeto con los registros relacionados al modelo PayrollStaff
     */
    public function payroll_staffs()
    {
    	return $this->hasMany(PayrollStaff::class);
    }
}
