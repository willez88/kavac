<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

/**
 * @class Profession
 * @brief Datos de Profesiones
 *
 * Gestiona el modelo de datos para las Profesiones
 *
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class Profession extends Model
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
     * @var array $fillable
     */
    protected $fillable = ['name', 'acronym'];

    /**
     * Método que genera un listado de opciones a implementar en elementos tipo select
     *
     * @author  William Páez (wpaez@cenditel.gob.ve)
     * @return array Profesiones registradas para ser implementados en plantillas
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
