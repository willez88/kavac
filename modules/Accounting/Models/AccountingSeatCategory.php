<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

class AccountingSeatCategory extends Model implements Recordable
{
    use SoftDeletes;
    use RecordableTrait;

    protected $fillable = ['name','acronym'];

    /**
     * AccountingSeatCategory has one AccountingSeat.
     *
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountingSeats()
    {
        return $this->hasMany(AccountingSeat::class, 'accounting_seat_categories_id');
    }
}
