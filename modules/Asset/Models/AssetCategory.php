<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class AssetCategory
 * @brief Datos de las categorias generales de un bien
 *
 * Gestiona el modelo de datos de las categorias generales de un bien
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class AssetCategory extends Model implements Auditable
{
    use SoftDeletes;
    use AuditableTrait;

    /**
     * Lista de atributos para la gestión de fechas
     *
     * @var array $dates
     */
    protected $dates = ['deleted_at'];

    /**
     * Lista de atributos que pueden ser asignados masivamente
     *
     * @var array $fillable
     */
    protected $fillable = ['code','name', 'asset_type_id'];

    /**
     * Método que obtiene el tipo de bien asociado a la categoria
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo AssetType
     */
    public function assetType()
    {
        return $this->belongsTo(AssetType::class);
    }

    /**
     * Método que obtiene las subcategorias asociadas a la categoria
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * AssetSubcategories
     */
    public function assetSubcategories()
    {
        return $this->hasmany(AssetSubcategory::class);
    }

    /**
     * Método que obtiene los bienes asociadps a la categoria
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo Asset
     */
    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
}
