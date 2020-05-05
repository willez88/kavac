<?php

namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;
/**
 * @class SaleSettingProduct
 * @brief Datos de productos
 *
 * Gestiona el modelo de los productos
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class SaleSettingProduct extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['sale_setting_product_type_id', 'name', 'code', 'description', 'price', 'iva'];

    /**
     * Lista de registros relacionados
     * @var array $with
    */
    protected $with = ['SaleSettingProductType'];

    /**
     * Método que obtiene el tipo de producto
     *
     * @author  Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function SaleSettingProductType()
    {
        return $this->belongsTo(SaleSettingProductType::class);
    }
}
