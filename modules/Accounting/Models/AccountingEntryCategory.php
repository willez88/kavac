<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class AccountingEntryCategory extends Model implements Auditable
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
    protected $fillable = ['name','acronym','institution_id'];

    /**
     * AccountingEntryCategory has many AccountingEntries.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accountingEntries()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = accountingEntryCategory_id, localKey = id)
        return $this->hasMany(AccountingEntry::class);
    }
}
