<?php

namespace Modules\Sale\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

class SaleQuoteProducts extends Model implements Auditable
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
  protected $fillable = ['id', 'name_enterprise', 'address_applicant', 'name_applicant', 'email_applicant', 'phone_applicant', 'measurement_units', 'quantity_product', 'payment_type_product', 'reply_deadline_product'];
}
