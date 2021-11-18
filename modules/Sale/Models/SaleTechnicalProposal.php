<?php
/** [descripción del namespace] */
namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class SaleTechnicalProposal
 * @brief [descripción detallada]
 *
 * [descripción corta]
 *
 * @author [autor de la clase] [correo del autor]
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class SaleTechnicalProposal extends Model implements Auditable
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
    protected $fillable = ['duration', 'frecuency_id', 'sale_service_id', 'sale_list_subservices',
                            'asset_asignations', 'payroll_staffs'];

    /**
     * Lista de atributos que deben ser asignados a tipos nativos.
     * @var array
     */
    protected $casts = [
        'sale_list_subservices' => 'json',
        'payroll_staffs' => 'json',
    ];


    /**
     * Método que obtiene las solicitudes de servicios almacenados en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleService
     */
    public function saleService()
    {
        return $this->belongsTo(SaleService::class);
    }

    /**
     * Método que obtiene las solicitudes de servicios almacenados en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleSettingFrecuency
     */
    public function saleSettingFrecuency()
    {
        return $this->belongsTo(SaleSettingFrecuency::class);
    }

    /**
     * Método que obtiene la lista de cargos almacenados en el modulo payroll
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * PayrollEmployment
     */
    public function payrollEmployment()
    {
        return $this->belongsTo(\Modules\Payroll\Models\PayrollEmployment::class);
    }

    /**
     * Método que obtiene la lista de trabajadores almacenados en el modulo payroll
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
     * Método que obtiene la lista de subservicios almacenados en el sistema
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleListSubservices
     */
    public function saleListSubservices()
    {
        return $this->belongsTo(SaleListSubservices::class);
    }

    /**
     * Método que obtiene la lista de especificaciones para la propuesta técnica
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\hasMany Objeto con el registro relacionado al modelo
     * SaleProposalSpecification
     */
    public function saleProposalSpecification()
    {
        return $this->hasMany(SaleProposalSpecification::class);
    }

    /**
     * Método que obtiene la lista de requerimientos para la propuesta técnica
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\hasMany Objeto con el registro relacionado al modelo
     * SaleProposalRequirement
     */
    public function saleProposalRequirement()
    {
        return $this->hasMany(SaleProposalRequirement::class);
    }

    /**
     * Método que obtiene la lista de bienes asignados almacenados en el modulo asset
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * AssetAsignation
     */
    public function assetAsignation()
    {
        return $this->belongsTo(\Modules\Asset\Models\AssetAsignation::class);
    }

    /**
     * Método que obtiene los registros almacenados en el modelo SaleGanttDiagram
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\hasMany Objeto con el registro relacionado al modelo
     * SaleGanttDiagram
     */
    public function saleGanttDiagram()
    {
        return $this->hasOne(\Modules\Asset\Models\SaleGanttDiagram::class);
    }
}
