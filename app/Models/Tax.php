<?php

/** Modelos generales de base de datos */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class Tax
 * @brief Datos de Impuestos
 *
 * Gestiona el modelo de datos para los impuestos
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class Tax extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /**
     * Lista de atributos para la gestión de fechas
     *
     * @var    array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var    array $fillable
     */
    protected $fillable = [
        'name', 'description', 'affect_tax', 'active'
    ];

    /**
     * Oculta los campos de fechas de creación, actualización y eliminación
     *
     * @var    array $hidden
     */
    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    /**
     * Método que obtiene los históricos de los impuestos
     *
     * @method  histories
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @return object Objeto con los registros relacionados al modelo HistoryTax
     */
    public function histories()
    {
        return $this->hasMany(HistoryTax::class);
    }
}
