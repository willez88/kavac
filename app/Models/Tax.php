<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

/**
 * @class Tax
 * @brief Datos de Impuestos
 * 
 * Gestiona el modelo de datos para los impuestos
 * 
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class Tax extends Model
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
    protected $fillable = [
    	'name', 'description', 'affect_tax', 'active'
    ];

    /**
     * Método que obtiene los históricos de los impuestos
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return object Objeto con los registros relacionados al modelo HistoryTax
     */
    public function histories()
    {
        return $this->hasMany(HistoryTax::class);
    }
}
