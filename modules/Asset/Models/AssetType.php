<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

/**
 * @class AssetType
 * @brief Datos de los tipo de bienes
 * 
 * Gestiona el modelo de datos para los tipos de bien
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetType extends Model
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
     *
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['name'];

    /**
     * Método que obtiene la categoria general de un bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con los registros relacionados al modelo AssetCategory
     */
    public function categories()
    {
    	return $this->hasMany('Modules\Asset\Models\AssetCategory');
    }

    /**
     * Método que obtiene los bienes del tipo de bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo Asset
     */
    public function assets()
    {
        return $this->hasMany('Modules\Asset\Models\Asset');
    }


    /**
     * Método que genera un listado de opciones a implementar en elementos tipo select
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Listado de tipos de bien registrados para ser implementados en plantillas
     */
    public static function template_choices($filters = [])
    {
        $records = self::all();
        if ($filters) {
            foreach ($filters as $key => $value) {
                $records = $records->where($key, $value);
            }
        }
        $options = [];
        foreach ($records as $rec) {
            $options[$rec->id] = $rec->name;
        }
        return $options;
    }


}
