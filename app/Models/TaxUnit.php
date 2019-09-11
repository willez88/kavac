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
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

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
class TaxUnit extends Model implements Recordable
{
    use SoftDeletes;
    use RecordableTrait;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at', 'strat_date', 'end_date'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['value', 'start_date', 'end_date', 'active'];
}
