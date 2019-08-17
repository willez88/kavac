<?php

namespace Modules\Purchase\Models;

use App\Models\Department as BaseDepartment;

class Department extends BaseDepartment
{
    /**
     * Department has many PurchaseRequirements.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function contratingPurchaseRequirements()
    {
        return $this->hasMany(PurchaseRequirement::class, 'contracting_department_id');
    }

    /**
     * Department has many UserPurchaseRequirements.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userPurchaseRequirements()
    {
        return $this->hasMany(PurchaseRequirement::class, 'user_department_id');
    }
}
