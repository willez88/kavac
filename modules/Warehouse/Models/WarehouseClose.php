<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * @class WarehouseClose
 * @brief Datos de los cierres de almacén
 *
 * Gestiona el modelo de datos para los cierres de almacén registrados
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseClose extends Model implements Recordable
{
    use SoftDeletes;
    use RecordableTrait;

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
    protected $fillable = [
        'initial_date', 'end_date', 'initial_user_id', 'end_user_id', 'warehouse_id', 'observations'
    ];

    /**
    * Método que obtiene el usuario que inicio el cierre del almacén
    *
    * @author Henry Paredes <hparedes@cenditel.gob.ve>
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo User
    */
    public function initialUser()
    {
        return $this->belongsTo(\App\User::class, 'initial_user_id');
    }

    /**
     * Método que obtiene el usuario que finalizó el cierre del almacén
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo User
     */
    public function endUser()
    {
        return $this->belongsTo(\App\User::class, 'end_user_id');
    }

    /**
     * Método que obtiene el almacén involucrado el en cierre de funciones
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo Warehouse
     */
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }
}
