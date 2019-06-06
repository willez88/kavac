<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class AccountingAccount
 * @brief Datos de cuentas del Clasificador Patrimoniales
 * 
 * Gestiona el modelo de datos para las cuentas del Clasificador Patrimoniales
 * 
 * @author Juan Rosas <JuanFBass17@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class AccountingAccount extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;
    
    /**
     * Establece el uso o no de bitácora de registros para este modelo
     * @var boolean $revisionCreationsEnabled
     */
    protected $revisionCreationsEnabled = true;

    /**
     * Lista de atributos para la gestión de fechas
     *
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

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
        return $this->hasMany(AccountingSeatAccount::class);
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
