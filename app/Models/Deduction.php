<?php

/** Modelos generales de base de datos */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Module;

/**
 * @class Deduction
 * @brief Datos de Deducciones
 *
 * Gestiona el modelo de datos para las Deducciones
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class Deduction extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /**
     * Lista de atributos para la gestión de fechas
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = ['name', 'description', 'formula', 'active', 'accounting_account_id'];

    /**
     * MaritalStatus has many PayrollStaff.
     *
     * @return array|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accountingAccount()
    {
        return (Module::has('Accounting'))?$this->belongsTo(\Modules\Accounting\Models\AccountingAccount::class):[];
    }
}
