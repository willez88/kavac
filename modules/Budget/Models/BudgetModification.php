<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class BudgetModification
 * @brief Datos de las modificaciones presupuestarias
 *
 * Gestiona el modelo de datos para las modificaciones presupuestarias (Crédito Adicional, Traspasos y Reducciones)
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class BudgetModification extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;

    /**
     * @type boolean Establece si el modelo es incorporado al registro de revisiones
     * o eventos de usuarios
     */
    protected $revisionCreationsEnabled = true;

    /** @var array Establece las relaciones por defecto que se retornan con las consultas */
    protected $with = ['budgetModificationAccounts', 'institution'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'approved_at'];


    protected $fillable = [
        'approved_at', 'code', 'type', 'description', 'document', 'institution_id',
        'document_status_id'
    ];

    /**
     * BudgetModification has many BudgetModificacionAccounts.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function budgetModificationAccounts()
    {
        return $this->hasMany(BudgetModificationAccount::class);
    }

    /**
     * BudgetModifications belongs to Institution.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function institution()
    {
        return $this->belongsTo(Institution::class);
    }

    /**
     * BudgetModifications belongs to DocumentStatus.
     *
     * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function documentStatus()
    {
        return $this->belongsTo(DocumentStatus::class);
    }
}
