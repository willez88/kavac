<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class Accountable
 * @brief Clase que gestiona la relacion N-M entre cuentas patrimoniales y otros registros
 *
 * Gestiona la relacion N-M entre cuentas patrimoniales y otros registros
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *                LICENCIA DE SOFTWARE CENDITEL
 *            </a>
 */
class Accountable extends Model implements Auditable
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
		'accounting_account_id', 
		'accountable_type', 
		'accountable_id', 
		'active'
	];

	/**
	 * Accountable belongs to AccountingAccount.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function accountingAccount()
	{
		// belongsTo(RelatedModel, foreignKey = accountingAccount_id, keyOnRelatedModel = id)
		return $this->belongsTo(AccountingAccount::class, 'accounting_account_id');
	}

	/**
	 * Accountable belongs to BudgetAccount.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function budgetAccount()
	{
		// belongsTo(RelatedModel, foreignKey = budgetAccount_id, keyOnRelatedModel = id)
		return $this->belongsTo($this->accountable_type, 'accountable_id');
	}
}
