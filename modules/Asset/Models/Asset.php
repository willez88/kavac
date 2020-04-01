<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

//use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Models\Institution;

/**
 * @class Asset
 * @brief Datos de los bienes institucionales
 *
 * Gestiona el modelo de datos de los bienes institucionales
 *
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @license <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>
 *              LICENCIA DE SOFTWARE CENDITEL
 *          </a>
 */
class Asset extends Model implements Auditable
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
    protected $fillable = [
        'asset_type_id', 'asset_category_id', 'asset_subcategory_id', 'asset_specific_category_id',
        'asset_condition_id', 'asset_acquisition_type_id', 'acquisition_date', 'asset_status_id',
        'serial', 'marca', 'model', 'inventory_serial', 'value', 'asset_use_function_id',
        'specifications', 'address', 'parish_id', 'currency_id', 'institution_id'
    ];

    /**
     * Método que obtiene el serial de inventario de un bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return string Retorna el serial de inventario de un bien
     */
    public function getCode()
    {
        $date = strtotime($this->acquisition_date);
        $year = date("Y", $date);
        return $this->asset_type_id . '-' . $this->asset_category_id . '-' .
        $this->asset_subcategory_id . '-' . $this->asset_specific_category_id . '-' .
        $year     . '-' . $this->id;
    }

    /**
     * Método que obtiene la descripción técnica de un bien institucional
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return string Retorna la descripción técnica de un bien
     */
    public function getDescription()
    {
        $description = 'Código: ' . $this->getCode() . '. ' .
                       'Marca: '  . $this->marca . '. ' .
                       'Modelo: ' . $this->model;
        if ($this->asset_type_id == 2) {
            $description = $description . '. Serial: ' . $this->serial;
        }
        return $description;
    }

    /**
     * Método que obtiene el tipo al que pertenece el bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo AssetType
     */
    public function assetType()
    {
        return $this->belongsTo(AssetType::class);
    }

    /**
     * Método que obtiene la categoria a la que pertenece el bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * AssetCategory
     */
    public function assetCategory()
    {
        return $this->belongsTo(AssetCategory::class);
    }

    /**
     * Método que obtiene la subcategoria a la que pertenece el bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * AssetSubcategory
     */
    public function assetSubcategory()
    {
        return $this->belongsTo(AssetSubcategory::class);
    }

    /**
     * Método que obtiene la categoria específica a la que pertenece el bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * AssetSpecificCategory
     */

    public function assetSpecificCategory()
    {
        return $this->belongsTo(AssetSpecificCategory::class);
    }

    /**
     * Método que obtiene el tipo de adquisicion del bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * AssetAcquisitionType
     */
    public function assetAcquisitionType()
    {
        return $this->belongsTo(AssetAcquisitionType::class);
    }

    /**
     * Método que obtiene la condición física del bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * AssetCondition
     */
    public function assetCondition()
    {
        return $this->belongsTo(AssetCondition::class);
    }

    /**
     * Método que obtiene el estatus de uso del bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * AssetStatus
     */
    public function assetStatus()
    {
        return $this->belongsTo(AssetStatus::class);
    }

    /**
     * Método que obtiene la función de uso del bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo
     * AssetUseFunction
     */
    public function assetUseFunction()
    {
        return $this->belongsTo(AssetUseFunction::class);
    }

    /**
     * Método que obtiene los bienes asignados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne Objeto con el registro relacionado al modelo
     * AssetAsignationAsset
     */

    public function assetAsignationAsset()
    {
        return $this->hasOne(AssetAsignationAsset::class);
    }

    /**
     * Método que obtiene los bienes desincorporados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne Objeto con el registro relacionado al modelo
     * AssetDisincorporationAsset
     */
    public function assetDisincorporationAsset()
    {
        return $this->hasOne(AssetDisincorporationAsset::class);
    }

    /**
     * Método que obtiene los bienes solicitados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne Objeto con el registro relacionado al modelo
     * AssetRequestAsset
     */
    public function assetRequestAsset()
    {
        return $this->hasOne(AssetRequestAsset::class);
    }

    /**
     * Método que obtiene los bienes inventariados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo
     * AssetInventoryAsset
     */
    public function assetInventoryAssets()
    {
        return $this->hasMany(AssetInventoryAsset::class);
    }

    /**
     * Método que obtiene la parroquia donde esta ubicado el bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo Parish
     */
    public function parish()
    {
        return $this->belongsTo(\App\Models\Parish::class);
    }

    /**
     * Método que obtiene la moneda en que se expresa el valor del bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo Currency
     */
    public function currency()
    {
        return $this->belongsTo(\App\Models\Currency::class);
    }

    /**
     * Método que obtiene la institución a la que pertenece el bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo Institution
     */
    public function institution()
    {
        return $this->belongsTo(\App\Models\Institution::class);
    }

    /**
     * Método que obtiene los bienes registrados filtrados por su clasificación
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [string] $type           Tipo del bien
     * @param  [string] $category       Categoria general del bien
     * @param  [string] $subcategory    Subcategoria del bien
     * @param  [string] $specific       Categoria específica del bien
     * @return [Object]             Objeto con los bienes registrados
     */
    public function scopeCodeClasification($query, $type, $category, $subcategory, $specific)
    {
        if ($type != "") {
            if ($category != "") {
                if ($subcategory != "") {
                    if ($specific != "") {
                        return $query->where('asset_type_id', $type)
                                     ->where('asset_category_id', $category)
                                     ->where('asset_subcategory_id', $subcategory)
                                     ->where('asset_specific_category_id', $specific);
                    }
                    return $query->where('asset_type_id', $type)
                             ->where('asset_category_id', $category)
                              ->where('asset_subcategory_id', $subcategory);
                }
                return $query->where('asset_type_id', $type)
                             ->where('asset_category_id', $category);
            }
            return $query->where('asset_type_id', $type);
        }
    }

    /**
     * Método que obtiene los bienes registrados filtrados por la fecha de registro
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [timestamp] $start   Fecha de inicio de busqueda
     * @param  [timestamp] $end     Fecha de fin de busqueda
     * @param  [string] $mes        Mes de busqueda
     * @param  [year] $year         Año de busqueda
     * @return [Object]             Objeto con los bienes registrados
     */
    public function scopeDateClasification($query, $start, $end, $mes, $year)
    {
        if (!is_null($start)) {
            if (!is_null($end)) {
                return $query->whereBetween("created_at", [$start,$end]);
            } else {
                return $query->whereBetween("created_at", [$start,now()]);
            }
        }

        if (!is_null($mes)) {
            if (!is_null($year)) {
                return $query->whereMonth('created_at', $mes)
                             ->whereYear('created_at', $year);
            } else {
                return $query->whereMonth('created_at', $mes);
            }
        }
    }

    /**
     * Método que obtiene los bienes registrados filtrados por la ubicación dentro de la institución
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @param  [Integer] $institution   Identificador único de la institución
     * @param  [Integer] $department    Identificador único del departamento o dependencia
     * @return [Object]                 Objeto con los bienes registrados
     */
    public function scopeDependenceClasification($query, $institution, $department)
    {
        /**
         * Falta asociar con la institución
         * Ojo: Debe ser los equipos que ya han sido asignados
         */
    }
}
