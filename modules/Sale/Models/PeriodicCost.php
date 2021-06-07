<?php
/** [descripción del namespace] */
namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

use App\Models\Currency;

/**
 * @class PeriodicCost
 * @brief Modelo de Costos fijos
 *
 * Modelo de Costos fijos
 *
 * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class PeriodicCost extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['name', 'description', 'value', 'currency_id', 'frecuency_id', 'attributes'];

     /**
     * Método que obtiene el tipo de moneda asignado al costo fijo
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * Currency
     */
    public function Currency()
    {
        return $this->belongsTo(Currency::class);
    }

     /**
     * Método que obtiene la periodicidad de pago del costo fijo
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * Frecuency
     */
    public function Frecuency()
    {
        return $this->belongsTo(SaleSettingFrecuency::class);
    }

    /**
     * Método que obtiene la lista de atributos de un costo fijo
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\hasMany Objeto con el registro relacionado al modelo
     * PeriodicCostAttribute
     */
    public function periodicCostAttribute()
    {
        return $this->hasMany(PeriodicCostAttribute::class);
    }
}
