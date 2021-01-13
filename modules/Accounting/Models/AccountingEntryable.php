<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

/**
 * @class AccountingEntryable
 * @brief Clase que gestiona la relacion N-M entre asientos contables y otros registros
 *
 * Gestiona la relacion N-M entre cuentas patrimoniales y otros registros
 *
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class AccountingEntryable extends Model implements Auditable
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
        'accounting_entry_id',
        'accounting_entryable_type',
        'accounting_entryable_id',
    ];


    /**
     * AccountingEntryable morphs to models in accounting_entryable_type.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function accounting_entryable()
    {
        // morphTo($name = accounting_entryable, $type = accounting_entryable_type, $id = accounting_entryable_id)
        // requires accounting_entryable_type and accounting_entryable_id fields on $this->table
        return $this->morphTo();
    }

    /**
     * AccountingEntryable belongs to AccountingEntry.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountingEntry()
    {
        // belongsTo(RelatedModel, foreignKey = accountingEntry_id, keyOnRelatedModel = id)
        return $this->belongsTo(AccountingEntry::class);
    }
}
