<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class WarehouseInventaryProduct
 * @brief Datos del inventario de los productos 
 * 
 * Gestiona el modelo de datos del inventario de los productos almacenables
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class WarehouseInventaryProduct extends Model implements Auditable
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
    protected $fillable = ['exist','reserved','product_id','unit_id','unit_value','warehouse_institution_id'];

    /**
     * Método que obtiene el producto gestionado
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo WarehouseProduct
     */

    public function product()
    {
        return $this->belongsTo('Modules\Warehouse\Models\WarehouseProduct','product_id');
    }

    /**
     * Método que obtiene la unidad métrica del producto gestionado
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo WarehouseProductUnit
     */

    public function unit()
    {
        return $this->belongsTo('Modules\Warehouse\Models\WarehouseProductUnit','unit_id');
    }

    /**
     * Método que obtiene el almacen donde se está inventariando el producto
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo Warehouse
     */
    
    public function warehouseInstitution()
    {
        return $this->belongsTo('Modules\Warehouse\Models\WarehouseInstitutionWarehouse','warehouse_institution_id');
    }

    public function productMovements()
    {
        return $this->hasMany('Modules\Warehouse\Models\WarehouseInventaryProductMovement','inventary_product_id');
    }

    /**
     * Método que obtiene las reglas de almacenamiento del producto en el inventario
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo WarehouseInventaryProduct
     */

    public function rule()
    {
        return $this->hasOne('Modules\Warehouse\Models\WarehouseInventaryRule','inventary_id');
    }
}
