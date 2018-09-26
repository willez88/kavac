<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class AssetPurchase
 * @brief Datos de las formas de adquisicion de un bien
 * 
 * Gestiona el modelo de datos para las formas de adquisición de los bienes
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class AssetCondition extends Model
{
    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['name'];

    /**
     * Método que obtiene los bienes de una condicion fisica
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
    public static function template_choices()
    {
        $options = [];
        foreach (self::all() as $reg) {
            $options[$reg->id] = $reg->name;
        }
        return $options;
    }
}

