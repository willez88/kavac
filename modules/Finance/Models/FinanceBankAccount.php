<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class FinanceBank
 * @brief Datos de las cuentas bancarias
 * 
 * Gestiona el modelo de datos para las cuentas bancarias
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class FinanceBankAccount extends Model implements Auditable
{
	use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;
    
    protected $revisionCreationsEnabled = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'opened_at'];

    protected $fillable = [
    	'ccc_number', 'description', 'opened_at', 'finance_banking_agency_id', 'finance_account_type_id'
    ];

    /**
     * FinanceBankAccount belongs to FinanceBankingAgency.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function finance_banking_agency()
    {
    	return $this->belongsTo(FinanceBankingAgency::class);
    }

    /**
     * FinanceBankAccount belongs to FinanceAccountType.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account_type()
    {
    	return $this->belongsTo(FinanceAccountType::class);
    }

    /**
     * FinanceBankAccount has many Finance_check_books.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function finance_check_books()
    {
        return $this->hasMany(FinanceCheckBook::class);
    }
}
