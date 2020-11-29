<?php

/** Modelos generales de base de datos */
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
 * @property  string  $symbol
 * @property  string  $name
 * @property  integer $country_id
 * @property  boolean $default
 * @property  integer $decimal_places
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

    /**
     * Oculta los campos de fechas de creación, actualización y eliminación
     *
     * @var    array $hidden
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Obtiene una descripción para la moneda
     *
     * @method    getDescriptionAttribute
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return    string                     Descripción de la moneda
     */
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
