<?php

namespace Modules\CitizenService\Models;

use App\Models\Municipality as BaseMunicipality;

class Municipality extends BaseMunicipality
{
    /**
     * Método que obtiene el municipio asociado con solicitudes
     *
     * @author Yennifer Ramirez <yramirezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function citizenServiceRequests()
    {
        return $this->hasMany(CitizenServiceRequest::class);
    }
}
