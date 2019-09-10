<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//use Venturecraft\Revisionable\RevisionableTrait;
/*use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;*/

/**
 * @class WarehouseReport
 * @brief Datos del historico de los reportes del modulo de almacén
 *
 * Gestiona el modelo de datos del historico de los reportes del modulo de almacén
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseReport extends Model //implements Auditable
{
    use SoftDeletes;
    //use RevisionableTrait;
    //use AuditableTrait;

    /**
     * Establece el uso o no de bitácora de registros para este modelo
     *
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
    protected $fillable = [
        'code', 'type_report', 'warehouse_product_id', 'warehouse_id', 'institution_id'
    ];
}
