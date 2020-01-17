<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Institution as BaseInstitution;

class Institution extends BaseInstitution
{
    /**
     * Institution has many AccoutingEntry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accoutingEntry()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = institution_id, localKey = id)
        return $this->hasMany(AccoutingEntry::class);
    }
}
