<?php

namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

class SaleClient extends Model implements Auditable
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
    protected $fillable = [
        'rif', 'business_name', 'representative_name', 'type_person_juridica', 'name', 'country_id', 'estate_id', 'municipality_id', 'parish_id', 'address_tax', 'name_client', 'emails', 'id_number', 'id_type'
    ];
    /**
     * Obtiene todos los número telefónicos asociados al cliente
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function phones()
    {
        return $this->morphMany(\App\Models\Phone::class, 'phoneable');
    }

    /**
     * Método que obtiene la lista de facturas del módulo de comercialización
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * SaleClients
     */
    public function saleBills()
    {
        return $this->hasMany(SaleBill::class);
    }

    /**
     * Método que obtiene las direcciones de correo del cliente
     *
     * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\hasMany Objeto con el registro relacionado al modelo
     * saleClientsEmail
     */
    public function saleClientsEmail()
    {
        return $this->hasMany(SaleClientsEmail::class);
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
