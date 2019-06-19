<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingCurrencyExchangeRate extends Model
{
    protected $fillable = ['currency_id','value','date','currency_base_id'];

    /**
     * AccountingCurrencyExchangeRate belongs to Currency.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
