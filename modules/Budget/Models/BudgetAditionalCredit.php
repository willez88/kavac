<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * @class BudgetAditionalCredit
 * @brief Datos de los créditos adicionales
 *
 * Gestiona el modelo de datos para los créditos adicionales
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class BudgetAditionalCredit extends Model implements Recordable
{
    use SoftDeletes;
    use RecordableTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'credit_date'];

    protected $fillable = ['code', 'credit_date', 'description', 'document', 'institution_id'];

    /**
     * BudgetAditionalCredits belongs to Institution.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * BudgetAditionalCredit has many BudgetAditionalCreditAccounts.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function aditionalCreditAccounts()
    {
        return $this->hasMany(BudgetAditionalCreditAccount::class);
    }
}
