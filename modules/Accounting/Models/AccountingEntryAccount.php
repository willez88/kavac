<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class AccountingEntryAccount extends Model implements Auditable
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
    protected $fillable = [
        'accounting_entry_id',
        'accounting_account_id',
        'debit',
        'assets'
    ];

    /**
     * AccountingEntryAccount belongs to AccountingEntry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function entries()
    {
        // belongsTo(RelatedModel, foreignKey = accountingEntry_id, keyOnRelatedModel = id)
        return $this->belongsTo(AccountingEntry::class, 'accounting_entry_id');
    }

    /**
     * AccountingEntryAccount belongs to AccountingAccount.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account()
    {
        // belongsTo(RelatedModel, foreignKey = accountingAccount_id, keyOnRelatedModel = id)
        return $this->belongsTo(AccountingAccount::class, 'accounting_account_id');
    }
}
