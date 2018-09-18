<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
 
/**
 * @class Subategory
 * @brief Datos de las subcategorias de un bien
 * 
 * Gestiona el modelo de datos para las subcategorias de un bien
 * 
 * @author 
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class subcategory extends Model
{
    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['code','name', 'asset_category_id'];

    /**
     * Método que obtiene la categoria del bien al que pertenece la subcategoria
     *
     * @author 
     * @return Objeto con el registro relacionado al modelo Category
     */
	public function categories()
    {
        return $this->belongsTo('App\Models\Category', 'asset_category_id');
    }

    /**
     * Método que obtiene la categoria especifica del bien al que pertenece la subcategoria
     *
     * @author 
     * @return Objeto con el registro relacionado al modelo specific_categories
     */
    public function specific_categories()
    {
        return $this->hasmany('App\Models\SpecificCategory');
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
