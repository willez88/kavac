<?php

namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

class SaleClients extends Model implements Auditable
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
  protected $fillable = ['id', 'rif', 'type_person_juridica', 'name', 'country_id', 'estate_id', 'city_id', 'municipality_id', 'parish_id', 'address', 'address_tax', 'name_client', 'email_client', 'phone_client'];

  /**
   * Obtiene todos los número telefónicos asociados al cliente
   *
   * @return \Illuminate\Database\Eloquent\Relations\MorphMany
   */
  public function phones()
  {
    return $this->morphMany(\App\Models\Phone::class, 'phoneable');
  }
}
