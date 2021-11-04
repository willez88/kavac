<?php

namespace Modules\Sale\Models;

use App\Models\Parish as BaseParish;

class Parish extends BaseParish
{
    /**
     * Método que obtiene la parroquia asociado con clientes
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function saleClient()
    {
        return $this->hasMany(SaleClient::class);
    }
}
