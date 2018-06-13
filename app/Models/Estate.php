<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

/**
 * @class Estate
 * @brief Datos de Estados
 * 
 * Gestiona el modelo de datos para los Estados
 * 
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class Estate extends Model
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
    protected $fillable = ['name', 'code', 'country_id'];

    /**
     * Método que obtiene el Pais de un Estado
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return Objeto con el registro relacionado al modelo Country
     */
	public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_id');
    }

    /**
     * Método que obtiene los Municipios de un Estado
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return Objeto con los registros relacionados al modelo Minicipality
     */
    public function municipalities()
    {
    	return $this->hasMany('App\Models\Municipality');
    }

    /**
     * Método que obtiene las Ciudades de un Pais
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return Objeto con los registros relacionados al modelo City
     */
    public function cities()
    {
        return $this->hasMany('App\Models\City');
    }

    /**
     * Método que genera un listado de opciones a implementar en elementos tipo select
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return Listado de Estados registrados para ser implementados en plantillas
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
