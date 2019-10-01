<?php

/** Modelos generales de base de datos */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class TaxUnit
 * @brief Datos de Unidades Tributarias (U.T.)
 *
 * Gestiona el modelo de datos para las unidades tributarias
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class TaxUnit extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at', 'start_date', 'end_date'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['value', 'start_date', 'end_date', 'active'];

    /**
     * Método mutador que permite obtener información del campo start_date en formato de fecha sin marca de tiempo
     *
     * @method     getStartDateAttribute
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return     string                 Devuelve la fecha en formato año-mes-día
     */
    public function getStartDateAttribute() : ?String
    {
        list($year, $month, $day) = explode("-", $this->attributes['start_date']);
        return "$year-$month-$day";
    }

    /**
     * Método mutador que permite obtener información del campo end_date en formato de fecha sin marca de tiempo
     *
     * @method     getEndDateAttribute
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return     string|null             Devuelve la fecha en formato año-mes-día
     */
    public function getEndDateAttribute() : ?String
    {
        if (is_null($this->attributes['end_date'])) {
            return null;
        }
        list($year, $month, $day) = explode("-", $this->attributes['end_date']);
        return "$year-$month-$day";
    }
}
