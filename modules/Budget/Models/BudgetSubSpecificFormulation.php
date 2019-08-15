<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class BudgetSubSpecificFormulation
 * @brief Datos de las formulaciones de presupuesto por sub específicas
 *
 * Gestiona el modelo de datos para las formulaciones de presupuesto por sub específicas
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class BudgetSubSpecificFormulation extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;

    protected $revisionCreationsEnabled = true;

    /** @var array Establece las relaciones por defecto que se retornan con las consultas */
    protected $with = ['specific_action'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'code', 'year', 'total_formulated', 'assigned', 'budget_specific_action_id',
        'currency_id', 'institution_id', 'document_status_id'
    ];

    /**
     * BudgetSubSpecificFormulation belongs to BudgetSpecificAction.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function specific_action()
    {
        return $this->belongsTo(BudgetSpecificAction::class, 'budget_specific_action_id');
    }

    /**
     * BudgetSubSpecificFormulation belongs to Currency.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * BudgetSubSpecificFormulation belongs to Institution.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * BudgetSubSpecificFormulation belongs to DocumentStatus.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function document_status()
    {
        // belongsTo(RelatedModel, foreignKey = document_status_id, keyOnRelatedModel = id)
        return $this->belongsTo(DocumentStatus::class);
    }

    /**
     * BudgetSubSpecificFormulation has many BudgetAccountOpen.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function accountOpens()
    {
        return $this->hasMany(BudgetAccountOpen::class);
    }

    /**
     * BudgetSubSpecificFormulation has many BudgetAditionalCreditAccounts.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function modification_accounts()
    {
        return $this->hasMany(BudgetModificationAccount::class);
    }

    /**
     * Método que permite validar si una formulación ya existe con los mismos datos a registrar, en cuyo caso
     * retorna verdadero
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  array  $data Campos a filtrar en la consulta
     * @return boolean      Devuelve verdadero si la formulación existe, de lo contrario retorna falso
     */
    public static function validateStore($data = [])
    {
        if (is_array($data) && !empty($data)) {
            $exists = self::where('institution_id', $data['institution_id'])
                          ->where('budget_specific_action_id', $data['budget_specific_action_id'])
                          ->where('currency_id', $data['currency_id'])->where('year', $data['year'])->first();
            return (!$exists);
        }

        return true;
    }

    /**
     * Scope para obtener la formulación de presupuesto vigente
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @param  object $query               Consulta del modelo
     * @param  integer $specific_action_id Identificador de la acción específica por la cual realizar el filtro
     * @return object                      Objeto con la consulta solicitada
     */
    public function scopeCurrentFormulation($query, $specific_action_id)
    {
        /** @var object Objeto con información referente al estado del documento */
        $documentStatus = DocumentStatus::where('action', 'AP')->first();

        return $query->where('budget_specific_action_id', $specific_action_id)
                     ->where('document_status_id', $documentStatus->id)
                     ->where('assigned', true)
                     ->orderBy('year', 'desc')->first();
    }
}
