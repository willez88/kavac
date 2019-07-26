<?php

namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Department as BaseDepartment;

class Department extends BaseDepartment
{
    /**
     * Department has many Purchase_requirements.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contrating_purchase_requirements()
    {
    	return $this->hasMany(PurchaseRequirement::class, 'contracting_department_id');
    }

    /**
     * Department has many User_purchase_requirements.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function user_purchase_requirements()
    {
    	return $this->hasMany(PurchaseRequirement::class, 'user_department_id');
    }
}
