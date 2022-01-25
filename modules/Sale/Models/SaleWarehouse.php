<?php

namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class SaleWarehouse
 * @brief Datos Almacenes
 *
 * Gestiona el modelo de almacenes
 *
 * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class SaleWarehouse extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;
    use ModelsTrait;

    protected $with = ['parish'];
    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['name','main','active','address','institution_id','country_id','estate_id',
                            'municipality_id','parish_id',];

    /**
     * Método que obtiene las instituciones que gestionan el almacén
     *
     * @author Miguel Narvaez <mnarvaez@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * SaleWarehouseInstitutionWarehouse
     */
    public function saleWarehouseInstitutionWarehouses()
    {
        return $this->hasMany(SaleWarehouseInstitutionWarehouse::class);
    }

    /**
     * Método que obtiene la solicitud asociado a una parroquia
     *
     * @author
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parish()
    {
        return $this->belongsTo(Parish::class);
    }
}