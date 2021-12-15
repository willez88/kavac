<?php

namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Models\User;

/**
 * @class SaleWarehouseMovement
 * @brief Datos de los movimientos de almacén
 *
 * Gestiona el modelo de datos para los movimientos de almacén
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class SaleWarehouseMovement extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

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
        'code', 'type', 'observations', 'state', 'sale_warehouse_institution_warehouse_initial_id',
        'sale_warehouse_institution_warehouse_end_id', 'user_id', 'description'
    ];

    
    /**
     * Método que obtiene el registro de institución gestiona almacén de donde parten los artículos
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * SaleWarehouseInstitutionWarehouse
     */
    public function saleWarehouseInstitutionWarehouseInitial()
    {
        return $this->belongsTo(SaleWarehouseInstitutionWarehouse::class)->with('sale_warehouse' ,'institution');
    }

    /**
     * Método que obtiene el registro de institución gestiona almacén donde llegan los artículos
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * SaleWarehouseInstitutionWarehouse
     */
    public function saleWarehouseInstitutionWarehouseEnd()
    {
        return $this->belongsTo(SaleWarehouseInstitutionWarehouse::class)->with('sale_warehouse' ,'institution');
    }

    /**
     * Método que obtiene el usuario que registra el movimiento
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Método que obtiene los cambios en los productos relacionados con el movimiento de almacén
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * SaleWarehouseInventoryProduct
     */
    public function saleWarehouseInventoryProductMovements()
    {
        return $this->hasMany(SaleWarehouseInventoryProductMovement::class);
    }
}
