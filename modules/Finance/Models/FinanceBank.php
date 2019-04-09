<?php

namespace Modules\Finance\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class FinanceBank extends Model implements Auditable
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

    protected $fillable = ['code', 'name', 'short_name', 'website', 'logo_id'];

    /**
     * FinanceBank has many Agencies.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function finance_agencies()
    {
        return $this->hasMany(FinanceBankingAgency::class);
    }

    /**
     * Método que obtiene el logotipo de la Entidad Bancaria
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve | roldandvg@gmail.com>
     * @return object Objeto con el registro relacionado al modelo Image
     */
    public function logo()
    {
        return $this->belongsTo(\App\Models\Image::class, 'logo_id');
    }
}
