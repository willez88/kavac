<?php

namespace Modules\CitizenService\Models;

use App\Models\City as BaseCity;

class City extends BaseCity
{
    /**
     * Método que obtiene la ciudad asociado con solicitudes
     *
     * @author Yennifer Ramirez <yramirezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function citizenServiceRequests()
    {
        return $this->hasMany(CitizenServiceRequest::class);
    }
}
