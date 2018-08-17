<?php

namespace Modules\Payroll\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

/**
 * @class PayrollStaff
 * @brief Datos del personal
 *
 * Gestiona el modelo de datos del personal
 *
 * @author William Páez (wpaez at cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class PayrollStaff extends Model
{
    use SoftDeletes;
    use RevisionableTrait;

    /**
     * Establece el uso o no de bitácora de registros para este modelo
     * @var boolean $revisionCreationsEnabled
     */
    protected $revisionCreationsEnabled = true;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = [
        'code', 'first_name', 'last_name', 'birthdate', 'sex', 'email', 'active', 'website', 'direction',
        'sons', 'start_date_public_adm', 'start_date', 'end_date', 'id_number', 'nationality', 'passport',
        'marital_status_id', 'professions_id', 'cities_id'
    ];

    /**
     * Método que genera un listado de opciones a implementar en elementos tipo select
     *
     * @author  William Páez (wpaez at cenditel.gob.ve)
     * @return [<b>List</b>] Listado de cargos registrados para ser implementados en plantillas
     */
    public static function template_choices()
    {
        $options = [];
        foreach (self::all() as $reg) {
            $options[$reg->id] = $reg->name;
        }
        return $options;
    }
}
