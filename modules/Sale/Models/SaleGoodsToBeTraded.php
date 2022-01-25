<?php
/** [descripción del namespace] */
namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class SaleGoodsToBeTraded
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class SaleGoodsToBeTraded extends Model implements Auditable
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
    protected $fillable = ['name', 'description', 'unit_price', 'define_attributes', 'currency_id', 'measurement_unit_id', 'department_id', 'history_tax_id' ,'payroll_staff_id', 'sale_type_good_id'];

    /**
     * Lista de atributos que deben ser asignados a tipos nativos.
     * @var array
     */
    protected $with = ['department'];

    /**
     * Método que obtiene las formas de pago almacenadas en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * Currency
     */
    public function currency()
    {
        return $this->belongsTo(\App\Models\Currency::class);
    }

    /**
     * Método que obtiene las unidades de medida almacenadas en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * MeasurementUnit
     */
    public function measurementUnit()
    {
        return $this->belongsTo(\App\Models\MeasurementUnit::class);
    }

    /**
     * Método que obtiene las unidades / dependencias almacenadas en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * Department
     */
    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class);
    }

    /**
     * Método que obtiene los porcentajes de impuestos almacenados en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * HistoryTax
     */
    public function historyTax()
    {
        return $this->belongsTo(\App\Models\HistoryTax::class);
    }

    /**
     * Método que obtiene l a lista de trabajadores almacenados en el modulo payroll
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * PayrollStaff
     */
    public function payrollStaff()
    {
        return $this->belongsTo(\Modules\Payroll\Models\PayrollStaff::class);
    }

    /**
     * Método que obtiene los atributos de los bienes a comercializar
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\belongsTo Objeto con el registro relacionado al modelo
     * saleTypeGood
     */
    public function saleTypeGood()
    {
        return $this->belongsTo(SaleTypeGood::class);
    }

    /**
     * Método que obtiene los atributos de los bienes a comercializar
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\hasMany Objeto con el registro relacionado al modelo
     * saleGoodsAttribute
     */
    public function saleGoodsAttribute()
    {
        return $this->hasMany(SaleGoodsAttribute::class);
    }

    /**
     * Método que obtiene los registros del formualrio de solicitud de servicios
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\hasMany Objeto con el registro relacionado al modelo
     * saleClientsEmail
     */
    public function saleService()
    {
        return $this->hasMany(SaleService::class);
    }
}
