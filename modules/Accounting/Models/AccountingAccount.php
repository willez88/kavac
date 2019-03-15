<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

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
     * Método que permite obtener el código de una cuenta presupuestaria
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return [string] Retorna el código de la cuenta
     */
    public function getCodeAttribute()
    {
        return "{$this->group}.{$this->item}.{$this->generic}.{$this->specific}.{$this->subspecific}";
    }
}
