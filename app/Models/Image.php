<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

/**
 * @class Image
 * @brief Datos de Imágenes
 * 
 * Gestiona el modelo de datos para las imágenes
 * 
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class Image extends Model
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
    protected $fillable = ['file', 'url', 'max_width', 'max_height', 'min_width', 'min_height'];

    /**
     * Método que obtiene las instituciones de las imágenes
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return Objeto con los registros relacionados al modelo Institution
     */
    public function institutions()
    {
        return $this->hasMany('App\Models\Institution');
    }
}
