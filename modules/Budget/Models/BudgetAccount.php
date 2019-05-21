<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * Se importa el modelo de AccountingAccountConverter del modulo Accounting
 * para la relación en la función account_converters
 * 
 * @author  Juan Rosas <JuanFBass17@gmail.com>
 */
use Modules\Accounting\Models\AccountingAccountConverter;

/**
 * @class BudgetAccount
 * @brief Datos de cuentas del Clasificador Presupuestario
 * 
 * Gestiona el modelo de datos para las cuentas del Clasificador Presupuestario
 * 
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class BudgetAccount extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;
    
    protected $revisionCreationsEnabled = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'group', 'item', 'generic', 'specific', 'subspecific', 'denomination', 'active', 'resource',
        'egress', 'tax_id', 'parent_id', 'original'
    ];

    /**
     * Reescribe el método boot para establecer comportamientos por defecto en la consulta del modelo
     * 
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     */
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('order', function (Builder $builder) {
            $builder->orderBy('group', 'asc')
                    ->orderBy('item', 'asc')
                    ->orderBy('generic', 'asc')
                    ->orderBy('specific', 'asc')
                    ->orderBy('subspecific', 'asc');
        });
    }

    /**
     * BudgetAccount has many BudgetAccountOpen.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function account_opens()
    {
        return $this->hasMany(BudgetAccountOpen::class);
    }

    /**
     * BudgetAccount has many BudgetModificationAccounts.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modification_accounts()
    {
        return $this->hasMany(BudgetModificationAccount::class);
    }

    /**
     * BudgetAccount has one AccountingAccountConverter.
     *
     * @author  Juan Rosas <JuanFBass17@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account_converters()
    {
        /** OJO: Independizar esta relación para que exista un módulo sin el otro */
        return $this->hasOne(AccountingAccountConverter::class);
    }

    /**
     * Restringe la eliminación de un registro si el mismo esta relacionado a otro modelo o posee campos 
     * que determinan la imposibilidad de su eliminación
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return [type] [description]
     */
    public function restrictDelete()
    {
        // Se debe agregar a esta comprobación todos los métodos con relación a otro modelo
        return (
            $this->has('account_opens')->get() || $this->has('modification_accounts')->get() || $this->has('account_converters')->get() ||
            $this->parent_id !== null || $this->original
        );
    }

    /**
     * Método que permite obtener la cuenta asociada de nivel superior
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @param  [string] $group       Grupo de la cuenta
     * @param  [string] $item        Ítem de la cuenta
     * @param  [string] $generic     Genérica de la cuenta
     * @param  [string] $specific    Específica de la cuenta
     * @param  [string] $subspecific Subespecífica de la cuenta
     * @return [boolean|object]      Retorna falso si no existe una cuenta de nivel superior, de lo contrario obtiene los datos de la misma
     */
    public static function getParent($group, $item, $generic, $specific, $subspecific)
    {
        if ($item !== '00') {
            $parent = self::where('group', $group);
            if ($generic !== '00') {
                $parent = $parent->where('item', $item);
                if ($specific !== '00') {
                    $parent = $parent->where('generic', $generic);
                    if ($subspecific !== '00') {
                        $parent = $parent->where('specific', $specific);
                    }
                    else {
                        $parent = $parent->where('subspecific', '00');
                    }
                }
                else {
                    $parent = $parent->where('specific', '00');
                }
            }
            else {
                $parent = $parent->where('generic', '00');
            }
        }
        
        if (!isset($parent)) {
            return false;
        }

        return $parent->first();
    }

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
