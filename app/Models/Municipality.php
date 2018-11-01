<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

/**
 * @class Municipality
 * @brief Datos de Municipios
 * 
 * Gestiona el modelo de datos para los Municipios
 * 
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class Municipality extends Model
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
    protected $fillable = ['name', 'code', 'estate_id'];

    /**
     * Método que obtiene el Estado de un Municipio
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return object Objeto con los registros relacionados al modelo Estate
     */
	public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

    /**
     * Método que obtiene las Parroquias asociadas a un Municipio
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return object Objeto con los registros relacionados al modelo Parish
     */
    public function parish()
    {
    	return $this->hasMany(Parish::class);
    }

    /**
     * Método que genera un listado de opciones a implementar en elementos tipo select
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return array Listado de Municipios registrados para ser implementados en plantillas
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
