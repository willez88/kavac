<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;
use App\Traits\ModelsTrait;

/**
 * @class City
 * @brief Datos de Ciudades
 * 
 * Gestiona el modelo de datos para las Ciudades
 * 
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class City extends Model
{
    use SoftDeletes;
    use RevisionableTrait;
    use ModelsTrait;

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
    protected $fillable = ['name', 'estate_id'];

    /**
     * Método que obtiene el Estado de una Ciudad
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return object Objeto con los registros relacionados al modelo Estate
     */
	public function estate()
    {
        return $this->belongsTo(Estate::class);
    }

    /**
     * City morphs to models in citiable_type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function citiable()
    {
        return $this->morphTo();
    }
}
