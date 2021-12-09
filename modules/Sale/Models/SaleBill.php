<?php

namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;
use Modules\Sale\Models\SaleBillInventoryProduct;

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
    protected $fillable = ['code', 'state', 'type', 'type_person', 'name', 'id_number', 'rif', 'phone', 'email', 'sale_form_payment_id'];

    /**
     * Lista de atributos personalizados obtenidos por defecto
     * @var array $appends
     */
    protected $appends = [
        'bill_total_without_taxs', 'bill_taxs', 'bill_totals'
    ];

    /**
     * Atributo que devuelve informacion de los bienes a comercializar
     *
     * @author    Daniel Contreras <dcontreras@cenditel.gob.ve>
     *
     * @return    $data
     */
    public function getBillTotalWithoutTaxsAttribute()
    {
        $billProducts = SaleBillInventoryProduct::get();
        $data = 0;

        foreach ($billProducts as $product){
            $value = $product->value * $product->quantity;
            $data += $value;
        }

        return $data;
    }

    /**
     * Atributo que devuelve informacion de los bienes a comercializar
     *
     * @author    Daniel Contreras <dcontreras@cenditel.gob.ve>
     *
     * @return    $data
     */
    public function getBillTaxsAttribute()
    {
        $billProducts = SaleBillInventoryProduct::with('historyTax')->get();
        $total_iva = 0;

        foreach ($billProducts as $product){
            if($product->historyTax){
                $value = $product->value * $product->quantity;
                $iva = $product->historyTax->percentage * $value / 100;
                $total_iva += $iva;
            }
        }

        return $total_iva;
    }

    /**
     * Atributo que devuelve informacion de los bienes a comercializar
     *
     * @author    Daniel Contreras <dcontreras@cenditel.gob.ve>
     *
     * @return    $data
     */
    public function getBillTotalsAttribute()
    {
        $billProducts = SaleBillInventoryProduct::with('historyTax')->get();
        $total_iva = 0;
        $total_value = 0;
        $total = 0;

        foreach ($billProducts as $product){
            $value = $product->value * $product->quantity;

            if($product->historyTax){
                $iva = $product->historyTax->percentage * $value / 100;
                $total_iva += $iva;
            }

            $total_value += $value;
            $total = $total_iva + $total_value;
        }

        return $total;
    }

    /**
     * Método que obtiene la lista de clientes del módulo de comercialización
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleClients
     */
    public function saleClient()
    {
        return $this->belongsTo(SaleClient::class);
    }

    /**
     * Método que obtiene la lista de almacenes del módulo de comercialización
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleWarehouse
     */
    public function saleWarehouse()
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
    public function saleFormPayment()
    {
        return $this->belongsTo(SaleFormPayment::class);
    }

    /**
     * Método que obtiene la lista de descuentos del módulo de comercialización
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleDiscount
     */
    public function saleDiscount()
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
    public function saleBillInventoryProduct()
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
