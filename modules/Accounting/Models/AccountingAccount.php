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
 * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
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
        'inactivity_date',
        'parent_id',
    ];

    /**
     * AccountingAccount has one AccountingAccountConverter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accountConverters()
    {
        return $this->hasOne(AccountingAccountConverter::class);
    }

    public function seatAccount()
    {
        return $this->hasMany(AccountingSeatAccount::class);
    }

    /**
     * Método que permite obtener la cuenta asociada de nivel superior
     *
     * @author Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @param  [string] $group       Grupo de la cuenta
     * @param  [string] $subgroup    Subgrupo de la cuenta
     * @param  [string] $item        Ítem de la cuenta
     * @param  [string] $generic     Genérica de la cuenta
     * @param  [string] $specific    Específica de la cuenta
     * @param  [string] $subspecific Subespecífica de la cuenta
     * @return [boolean|object]      Retorna falso si no existe una cuenta de nivel superior, de lo contrario obtiene los datos de la misma
     */
    public static function getParent($group, $subgroup, $item, $generic, $specific, $subspecific)
    {
        if ($subgroup !== '0') {
            $parent = self::where('group', $group);
            if ($item !== '0') {
                $parent = $parent->where('subgroup', $subgroup);
                if ($generic !== '00') {
                    $parent = $parent->where('item', $item);
                    if ($specific !== '00') {
                        $parent = $parent->where('generic', $generic);
                        if ($subspecific !== '00') {
                            $parent = $parent->where('specific', $specific);
                        } else {
                            $parent = $parent->where('specific', '00');
                        }
                    } else {
                        $parent = $parent->where('generic', '00');
                    }
                } else {
                    $parent = $parent->where('item', '0');
                }
            } else {
                $parent = $parent->where('subgroup', '0');
            }
        } else {
            $parent = self::where('group', $group)->where('subgroup', '0');
        }

        if (!isset($parent)) {
            return false;
        }

        return $parent->first();
    }

    /**
     * AccountingAccount has Many AccountingAccount.
     *
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function children()
    {
        return $this->hasMany(AccountingAccount::class, 'parent_id');
    }

    /**
     * AccountingAccount belongs to AccountingAccount.
     *
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     */
    public function parent()
    {
        return $this->BelongsTo(AccountingAccount::class, 'parent_id');
    }

    /**
     * Contatena ciertos valores del registro para generar el codigo
     * correspondiente
     *
     * @author  Juan Rosas <jrosas@cenditel.gob.ve | juan.rosasr01@gmail.com>
     * @return [string] [codigo que identifica a la cuenta]
     */
    public function getCode()
    {
        return "{$this->group}.{$this->subgroup}.{$this->item}.{$this->generic}.{$this->specific}.{$this->subspecific}";
    }
}
