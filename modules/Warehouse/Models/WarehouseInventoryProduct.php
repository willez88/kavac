<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * @class WarehouseInventoryProduct
 * @brief Datos del inventario de los productos
 *
 * Gestiona el modelo de datos del inventario de los productos almacenables
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class WarehouseInventoryProduct extends Model implements Recordable
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
        'code', 'exist', 'reserved', 'unit_value', 'currency_id', 'warehouse_product_id',
        'measurement_unit_id', 'warehouse_institution_warehouse_id'
    ];

    /**
     * Método que obtiene el producto registrado
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * WarehouseProduct
     */
    public function warehouseProduct()
    {
        return $this->belongsTo(WarehouseProduct::class);
    }

    /**
     * Método que obtiene los valores de los atributos del producto registrado
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * WarehouseProductValue
     */
    public function warehouseProductValues()
    {
        return $this->hasMany(WarehouseProductValue::class);
    }

    /**
     * Método que obtiene la moneda en que se expresa el valor del producto
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo Currency
     */
    public function currency()
    {
        return $this->belongsTo(\App\Models\Currency::class);
    }


    /**
     * Método que obtiene la unidad de medida del producto registrado
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * MeasurementUnit
     */
    public function measurementUnit()
    {
        return $this->belongsTo(\App\Models\MeasurementUnit::class);
    }

    /**
     * Método que obtiene el almacen donde esta inventariado el producto
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * WarehouseInstitutionWarehouse
     */
    public function warehouseInstitutionWarehouse()
    {
        return $this->belongsTo(WarehouseInstitutionWarehouse::class);
    }

    /**
     * Método que obtiene las reglas de almacenamiento del producto en el inventario
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * WarehouseInventoryRule
     */
    public function warehouseInventoryRule()
    {
        return $this->hasOne(WarehouseInventoryRule::class);
    }
}
