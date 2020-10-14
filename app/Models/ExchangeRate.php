<?php

/** Modelos generales de base de datos */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class ExchangeRate
 * @brief Datos de Estados
 *
 * Gestiona el modelo de datos para los tipos de cambio
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class ExchangeRate extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at', 'start_at', 'end_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['start_at', 'end_at', 'amount', 'active', 'from_currency_id', 'to_currency_id'];

    /**
     * ExchangeRate belongs to Currency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fromCurrency()
    {
        return $this->belongsTo(Currency::class, 'from_currency_id');
    }

    /**
     * ExchangeRate belongs to Currency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function toCurrency()
    {
        return $this->belongsTo(Currency::class, 'to_currency_id');
    }

    /**
     * Método mutador que permite obtener información del campo start_at en formato de fecha sin marca de tiempo
     *
     * @method     getStartAtAttribute()
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return     string                 Devuelve la fecha en formato año-mes-día
     */
    public function getStartAtAttribute() : ?String
    {
        list($year, $month, $day) = explode("-", $this->attributes['start_at']);
        return "$year-$month-$day";
    }

    /**
     * Método mutador que permite obtener información del campo end_at en formato de fecha sin marca de tiempo
     *
     * @method     getEndAtAttribute()
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return     string|null             Devuelve la fecha en formato año-mes-día
     */
    public function getEndAtAttribute() : ?String
    {
        if (is_null($this->attributes['end_at'])) {
            return null;
        }
        list($year, $month, $day) = explode("-", $this->attributes['end_at']);
        return "$year-$month-$day";
    }
}
