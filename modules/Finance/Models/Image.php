<?php

namespace Modules\Finance\Models;

use App\Models\Image as BaseImage;

class Image extends BaseImage
{
    /**
     * Image has many FinanceBank.
     *
     * @return array|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function financeBanks()
    {
        return $this->hasMany(FinanceBank::class, 'logo_id');
    }
}
