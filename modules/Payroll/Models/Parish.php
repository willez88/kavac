<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Parish as BaseParish;

class Parish extends BaseParish
{
    /**
     * Parish has many PayrollStaff
     *
     * @author William Páez <wpaezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function payroll_staffs()
    {
    	return $this->hasMany(PayrollStaff::class);
    }
}
