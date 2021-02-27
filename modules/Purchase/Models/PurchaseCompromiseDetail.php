<?php
/** [descripción del namespace] */
namespace Modules\Purchase\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class PurchaseCompromiseDetail
 * @brief Datos de los detalles de los compromisos de compras
 *
 * Gestiona el modelo de datos para los detalles de los compromisos Compromisos de Compras
 * Este modelo es usado en caso de que no se encuentre instalado el modulo de Presupuesto
 *
 * @author Ing. Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class PurchaseCompromiseDetail extends Model implements Auditable
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
    protected $fillable = [
        'description', 'amount', 'tax_amount', 'tax_id', 'budget_compromise_id', 'budget_account_id',
        'budget_sub_specific_formulation_id'
    ];

    /**
     * BudgetCompromiseDetail belongs to BudgetCompromise.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function budgetCompromise()
    {
        return $this->belongsTo(BudgetCompromise::class);
    }
}
