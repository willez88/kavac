<?php

namespace Modules\Accounting\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class AccountingSeatCategory extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;
    
    protected $fillable = ['name','acronym'];

    /**
     * AccountingSeatCategory has one AccountingSeat.
     *
     * @author  Juan Rosas <JuanFBass17@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accounting_seats()
    {
        return $this->hasMany(AccountingSeat::class, 'generated_by_id');
    }

}
