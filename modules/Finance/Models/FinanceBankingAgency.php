<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Altek\Accountant\Contracts\Recordable;
use Altek\Accountant\Recordable as RecordableTrait;

/**
 * @class FinanceBankingAgency
 * @brief Datos de las agencias bancarias
 *
 * Gestiona el modelo de datos para las agencias bancarias
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class FinanceBankingAgency extends Model implements Recordable
{
    use SoftDeletes;
    use RecordableTrait;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name', 'direction', 'headquarters', 'contact_person', 'contact_email',
        'finance_bank_id', 'city_id'
    ];

    /**
     * FinanceBankingAgency belongs to Bank.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function financeBank()
    {
        return $this->belongsTo(FinanceBank::class, 'finance_bank_id');
    }

    /**
     * FinanceBankingAgency morphs many city.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(\App\Models\City::class);
    }

    /**
     * FinanceBankingAgency has many FinanceBankAccount.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function bankAccounts()
    {
        return $this->hasMany(FinanceBankAccount::class);
    }

    /**
     * Obtiene todos los número telefónicos asociados a la agencia bancaria
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function phones()
    {
        return $this->morphMany(\App\Models\Phone::class, 'phoneable');
    }
}
