<?php

namespace Modules\CitizenService\Models;

use App\Models\Parish as BaseParish;

class Parish extends BaseParish
{
    /**
     * Método que obtiene la parroquia asociado con solicitudes
     *
     * @author Yennifer Ramirez <yramirezs@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function citizenServiceRequests()
    {
        return $this->hasMany(CitizenServiceRequest::class);
    }
}
