<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//use Venturecraft\Revisionable\RevisionableTrait;
/*use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;*/

class AccountingSeatCategory extends Model //implements Auditable
{
    use SoftDeletes;
    //use RevisionableTrait;
    //use AuditableTrait;

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
