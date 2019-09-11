<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

class AccountingSeat extends Model implements Recordable
{
    use SoftDeletes;
    use RecordableTrait;

    protected $fillable = [
        'from_date',
        'concept',
        'observations',
        'reference',
        'tot_debit',
        'tot_assets',
        'accounting_seat_categories_id',
        'institution_id',
        'departament_id',
        'approved'
    ];
    /**
     * AccountingSeat has many AccountingSeatAccount.
     *
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountingAccounts()
    {
        return $this->hasMany(AccountingSeatAccount::class);
    }

    /**
     * AccountingSeat belongs to AccountingSeatCategory.
     *
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function generatedBy()
    {
        return $this->belongsTo(AccountingSeatCategory::class);
    }

    /**
     * Indica si el asiento contable esta aprobado
     *
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return Boolena
     */
    public function approved()
    {
        return ($this->approved);
    }
}
