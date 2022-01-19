<?php
/** [descripción del namespace] */
namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

use App\Models\Estate as BaseEstate;

/**
 * @class Estate
 * @brief Extension de la clase Estate del modulo de presupuesto
 *
 * Extension de la clase Estate del modulo de presupuesto
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class Estate extends Model implements Auditable
{
    /**
     * Estate has many PurchaseSuppliers.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function purchaseSuppliers()
    {
        return $this->hasMany(PurchaseSupplier::class);
    }
}
