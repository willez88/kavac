<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class AssetCategory
 * @brief Datos de las Categorias Generales de un bien
 * 
 * Gestiona el modelo de datos para las categorias generales de un bien
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetCategory extends Model implements Auditable
{
	use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;

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
    protected $fillable = ['code','name', 'asset_type_id'];

    /**
     * Método que obtiene el tipo de bien al que pertenece la categoria
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetType
     */
	public function type()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetType', 'asset_type_id');
    }

    /**
     * Método que obtiene la subcategoria del bien al que pertenece la categoria
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetSubcategories
     */
    public function subcategories()
    {
        return $this->hasmany('Modules\Asset\Models\AssetSubcategory');
    }

    /**
     * Método que obtiene los bienes de la categoria
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo Asset
     */
    public function assets()
    {
        return $this->hasMany('Modules\Asset\Models\Asset');
    }

    /**
     *
     * @brief Método que genera un listado de elementos registrados para ser implementados en plantillas blade
     * 
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return [array] Listado de bienes
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
