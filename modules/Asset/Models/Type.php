<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class Type
 * @brief Datos de los tipo de bienes
 * 
 * Gestiona el modelo de datos para los tipos de bien
 * 
 * @author
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class type extends Model
{

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['name'];

    /**
     * Método que obtiene la categoria general de un bien
     *
     * @author  
     * @return Objeto con los registros relacionados al modelo category
     */
    public function categories()
    {
    	return $this->hasMany('App\Models\Category');
    }

    /**
     * Método que genera un listado de opciones a implementar en elementos tipo select
     *
     * @author
     * @return Listado de tipos de bien registrados para ser implementados en plantillas
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