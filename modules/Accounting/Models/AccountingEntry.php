<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

use Module;

class AccountingEntry extends Model implements Auditable
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
        'from_date',
        'concept',
        'observations',
        'reference',
        'tot_debit',
        'tot_assets',
        'accounting_entry_categories_id',
        'institution_id',
        'currency_id',
        'approved'
    ];

    protected $with = ['currency'];
    
    /**
     * AccountingEntry has many AccountingAccounts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accountingAccounts()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = accountingEntry_id, localKey = id)
        return $this->hasMany(AccountingEntryAccount::class, 'accounting_entry_id');
    }

    /**
     * AccountingEntry belongs to AccountingEntryCategory.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountingEntryCategory()
    {
        // belongsTo(RelatedModel, foreignKey = accountingEntryCategory_id, keyOnRelatedModel = id)
        return $this->belongsTo(AccountingEntryCategory::class, 'accounting_entry_categories_id');
    }

    /**
     * Indica si el asiento contable esta aprobado
     *
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return boolena
     */
    public function approved()
    {
        return ($this->approved);
    }

    /**
     * AccountingEntry belongs to Currency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        // belongsTo(RelatedModel, foreignKey = curr_id, keyOnRelatedModel = id)
        return $this->belongsTo(Currency::class);
    }
    /**
     * AccountingEntry belongs to Institution.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institution()
    {
        // belongsTo(RelatedModel, foreignKey = institution_id, keyOnRelatedModel = id)
        return $this->belongsTo(Institution::class);
    }

    /**
     * Método que obtiene los modelos morfológicos asociados a asientos contables
     *
     * @author    Juan Rosas <jrosas@cenditel.gob.ve> | <juan.rosasr01@gmail.com>
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pivotEntryable()
    {
        // hasMany(RelatedModel, foreignKeyOnRelatedModel = accountingEntry_id, localKey = id)
        return $this->hasMany(AccountingEntryable::class, 'accounting_entry_id');
    }

    /**
     * Query scope Column.
     *
     * @param
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  String $column [nombre de la columna en la que se desea buscar]
     * @param  String $search [texto que se buscara]
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeColumn($query, $column, $search)
    {
        if ($column && $search === '') {
            return $query;
        } elseif ($column && $search) {
            return $query->orWhere($column, 'LIKE', "%$search%");
        }
    }

    public function queryAccess($id)
    {
        if ($id != $this->institution_id && !auth()->user()->isAdmin()) {
            return true;
        }
        return false;
    }
}
