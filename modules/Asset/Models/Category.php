<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class Category
 * @brief Datos de las categorias generales de un bien
 * 
 * Gestiona el modelo de datos para las categorias generales de un bien
 * 
 * @author 
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class category extends Model
{

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['code','name', 'asset_type_id'];

    /**
     * Método que obtiene el tipo de bien al que pertenece la categoria
     *
     * @author 
     * @return Objeto con el registro relacionado al modelo Type
     */
	public function type()
    {
        return $this->belongsTo('App\Models\Type', 'asset_type_id');
    }

    /**
     * Método que obtiene la subcategoria del bien al que pertenece la categoria
     *
     * @author 
     * @return Objeto con el registro relacionado al modelo subcategories
     */
    public function subcategories()
    {
        return $this->hasmany('App\Models\Subcategory');
    }

    /**
     * Método que genera un listado de opciones a implementar en elementos tipo select
     *
     * @author
     * @return Listado de categorias generales registradas para ser implementados en plantillas
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
