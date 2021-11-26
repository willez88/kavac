<?php
/** [descripción del namespace] */
namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class SaleQuote
 * @brief Modelo para la gestion de cotizaciones en comercializacion
 *
 * Modelo para la gestion de cotizaciones en comercializacion
 *
 * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class SaleQuote extends Model implements Auditable
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
    protected $fillable = ['name','id_number', 'email', 'type_person', 'sale_payment_method_id', 'deadline_date', 'status', 'phone', 'total', 'total_without_tax'];

    protected $appends = array('status_text');

    /**
     * Método que obtiene los métodos de pago del módulo de comercialización
     *
     * PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SalePaymentMethod
     */
    public function salePaymentMethod()
    {
        return $this->belongsTo(SalePaymentMethod::class);
    }

    /**
     * Método que obtiene los productos de la cotizacion
     *
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\hasMany Objeto con el registro relacionado al modelo
     * saleQuoteProduct
     */
    public function saleQuoteProduct()
    {
        return $this->hasMany(SaleQuoteProduct::class);
    }

    /**
     * Metodo que establece es nombre en texto de los estados de las cotizaciones.
     * @author PHD. Juan Vizcarrondo <jvizcarrondo@cenditel.gob.ve> | <juanvizcarrondo@gmail.com>
     * @return string
     */
    public function getStatusTextAttribute()
    {
      $status_list = [2 => 'Cancelado', 0 => 'Creado', 1 => 'Aprobado'];
      return isset($status_list[$this->status])? $status_list[$this->status] : 'N/A';
    }
}
