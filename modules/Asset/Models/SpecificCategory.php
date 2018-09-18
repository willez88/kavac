<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
/**
 * @class specific_category
 * @brief Datos de las categorias especificas de un bien
 * 
 * Gestiona el modelo de datos para las categorias especificas de un bien
 * 
 * @author 
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class specificCategory extends Model
{
    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['code','name', 'asset_subcategory_id'];

    /**
     * Método que obtiene la subcategoria del bien al que pertenece la categoria especifica
     *
     * @author 
     * @return Objeto con el registro relacionado al modelo Subcategory
     */
	public function subcategories()
    {
        return $this->belongsTo('App\Models\Subcategory', 'asset_subcategory_id');
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
