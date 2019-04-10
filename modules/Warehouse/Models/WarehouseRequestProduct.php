<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class WarehouseRequestProduct
 * @brief Datos de los productos solicitados
 * 
 * Gestiona el modelo de datos de los productos almacenables solicitados
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseRequestProduct extends Model implements Auditable
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
     * @var array $fillable
     */
    protected $fillable = ['quantity', 'warehouse_request_id','warehouse_inventary_product_id'];

    /**
     * Método que obtiene el producto gestionado
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo WarehouseProduct
     */

    public function inventaryProduct()
    {
        return $this->belongsTo('Modules\Warehouse\Models\WarehouseInventaryProduct','warehouse_inventary_product_id');
    }

    /**
     * Método que obtiene la solicitud 
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo WarehouseRequest
     */

    public function request()
    {
        return $this->belongsTo('Modules\Warehouse\Models\WarehouseRequest','warehouse_request_id');
    }



    
}
