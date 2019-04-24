<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @class AccountingAccount
 * @brief Datos de cuentas del Clasificador Patrimoniales
 * 
 * Gestiona el modelo de datos para las cuentas del Clasificador Patrimoniales
 * 
 * @author Juan Rosas <JuanFBass17@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingAccount extends Model
{
    protected $fillable = [
		'group',
		'subgroup',
		'item',
		'generic',
		'specific',
		'subspecific',
		'denomination',
		'active',
		'inactivity_date'
	];
    
    /**
     * AccountingAccount has one AccountingAccountConverter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account_converters()
    {
        return $this->hasOne(AccountingAccountConverter::class);
    }

    public function seat_account()
    {
        return $this->hasOne(AccountingSeatAccount::class);
    }
    /**
     * Contatena ciertos valores del registro para generar el codigo
     * correspondiente
     *
     * @author  Juan Rosas <JuanFBass17@gmail.com>
     * @return [string] [codigo que identifica a la cuenta]
     */
    public function getCode()
    {
    	return "{$this->group}.{$this->subgroup}.{$this->item}.{$this->generic}.{$this->specific}.{$this->subspecific}";
    }
}
