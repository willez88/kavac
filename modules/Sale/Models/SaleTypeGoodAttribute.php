<?php

namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class SaleTypeGoodAttribute
 * @brief Datos de attributos en tipos de bienes
 *
 * Gestiona el modelo de los atributos de tipos de bienes
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class SaleTypeGoodAttribute extends Model implements Auditable
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
    protected $fillable = ['name', 'sale_type_good_id'];

    /**
     * Método que obtiene los tipos de bienes
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleTypeGood
     */
    public function saleTypeGood()
    {
        return $this->belongsTo(SaleTypeGood::class);
    }

    /**
     * Método que obtiene los valores de los atributos del tipo de bien
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne Objeto con el registro relacionado al modelo
     * SaleTypeGoodValue
     */
    public function saleTypeGoodValue()
    {
        return $this->hasOne(SaleTypeGoodValue::class);
    }
}
