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
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class Tax extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /**
     * @var array $dates Lista de atributos para la gestión de fechas
     */
    protected $dates = ['deleted_at'];

    /**
     * @var array $fillable Lista de atributos que pueden ser asignados masivamente
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
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return object Objeto con los registros relacionados al modelo HistoryTax
     */
    public function histories()
    {
        return $this->hasMany(HistoryTax::class);
    }
}
