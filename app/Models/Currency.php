<?php
/**
 * Models - Gestión de modelos comúnes
 *
 * @package  Models
 * @author   Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class Currency
 * @brief Datos de Monedas
 *
 * Gestiona el modelo de datos para las Monedas
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class Currency extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['symbol', 'name', 'country_id', 'default', 'decimal_places'];

    public function getDescriptionAttribute()
    {
        return "{$this->symbol} - {$this->name}";
    }

    /**
     * Currency belongs to Country.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Currency has many ExchangeRate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function fromExchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'from_currency_id');
    }

    /**
     * Currency has many ExchangeRate.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function toExchangeRates()
    {
        return $this->hasMany(ExchangeRate::class, 'to_currency_id');
    }
}
