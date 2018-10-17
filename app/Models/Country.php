<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

/**
 * @class Country
 * @brief Datos de Países
 * 
 * Gestiona el modelo de datos para los Países
 * 
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class Country extends Model
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
    protected $fillable = ['name', 'prefix'];

    /**
     * Método que obtiene el Estado de un Pais
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return Objeto con los registros relacionados al modelo Estate
     */
    public function estates()
    {
    	return $this->hasMany(Estate::class);
    }

    /**
     * Country has many Currencies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function currencies()
    {
        return $this->hasMany(Currency::class);
    }

    /**
     * Método que genera un listado de opciones a implementar en elementos tipo select
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @return Listado de Países registrados para ser implementados en plantillas
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
