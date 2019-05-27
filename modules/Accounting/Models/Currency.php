<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Currency as BaseCurrency;

class Currency extends BaseCurrency
{
    /**
     * Department has many AccountingCurrencyExchangeRate.
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exchange_rate_currency_base()
    {
        return $this->hasMany(AccountingCurrencyExchangeRate::class, 'currency_base_id');
    }
    public function exchange_rate_currency_id()
    {
        return $this->hasMany(AccountingCurrencyExchangeRate::class, 'currency_id');
    }
}
