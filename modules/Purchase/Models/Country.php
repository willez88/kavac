<?php
/** [descripción del namespace] */
namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use App\Models\Country as BaseCountry;

/**
 * @class Country
 * @brief Extension de la clase Country del modulo de presupuesto
 *
 * Extension de la clase Country del modulo de presupuesto
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class Country extends Model implements Auditable
{
    /**
     * Country has many PurchaseSuppliers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseSuppliers()
    {
        return $this->hasMany(PurchaseSupplier::class);
    }
}
