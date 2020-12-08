<?php

namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

class SaleBill extends Model implements Auditable
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
    protected $fillable = ['state', 'sale_client_id', 'sale_warehouse_id', 'sale_payment_method_id', 'currency_id', 'sale_discount_id'];

     /**
     * Método que obtiene la lista de clientes del módulo de comercialización
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleClients
     */
    public function SaleClients()
    {
        return $this->belongsTo(SaleClients::class);
    }

    /**
     * Método que obtiene la lista de almacenes del módulo de comercialización
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleWarehouse
     */
    public function SaleWarehouse()
    {
        return $this->belongsTo(SaleWarehouse::class);
    }

    /**
     * Método que obtiene la lista de métodos de pago del módulo de comercialización
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SalePaymentMethod
     */
    public function SalePaymentMethod()
    {
        return $this->belongsTo(SalePaymentMethod::class);
    }

    /**
     * Método que obtiene la lista de descuentos del módulo de comercialización
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleDiscount
     */
    public function SaleDiscount()
    {
        return $this->belongsTo(SaleDiscount::class);
    }

    /**
     * Método que obtiene la lista de productos guardados en el almacén del módulo de comercialización
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleBillInventoryProduct
     */
    public function SaleBillInventoryProduct()
    {
        return $this->hasMany(SaleBillInventoryProduct::class);
    }

     /**
     * Método que obtiene las formas de pago almacenadas en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * Currency
     */
    public function Currency()
    {
        return $this->belongsTo(\App\Models\Currency::class);
    }
}
