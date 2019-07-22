<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Venturecraft\Revisionable\RevisionableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use Module;

/**
 * @class Asset
 * @brief Datos de los bienes institucionales
 * 
 * Gestiona el modelo de datos de los bienes institucionales
 * 
 * @author Henry Paredes <hparedes@cenditel.gob.ve>
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class Asset extends Model implements Auditable
{
    use SoftDeletes;
    use RevisionableTrait;
    use AuditableTrait;

    /**
     * Establece el uso o no de bitácora de registros para este modelo
     *
     * @var boolean $revisionCreationsEnabled
     */
    protected $revisionCreationsEnabled = true;

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
        'asset_type_id', 'asset_category_id', 'asset_subcategory_id', 'asset_specific_category_id', 'asset_condition_id', 'asset_acquisition_type_id', 'acquisition_year', 'asset_status_id', 'serial', 'marca', 'model', 'inventory_serial', 'value', 'asset_use_function_id', 'specifications', 'address', 'parish_id'
    ];

    /**
     * Método que obtiene el serial de inventario de un bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return string Retorna el serial de inventario de un bien
     */
    public function getCode()
    {
        $code = $this->asset_type_id .'-'. $this->asset_category_id .'-'. $this->asset_subcategory_id .'-'. $this->asset_specific_category_id .'-'. $this->acquisition_year .'-'. $this->id;

        return $code;
    }

    /**
     * Método que obtiene la descripción técnica de un bien institucional
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return string Retorna la descripción técnica de un bien
     */
    public function getDescription()
    {
        $description = 'Código: '.$this->getCode() .'. Marca: '. $this->marca .'. Modelo: '. $this->model;
        if ($this->asset_type_id == 2){
            $description = $description . ". Serial: ". $this->serial;
        }
        return $description;
    }
    
    /**
     * Método que obtiene el tipo al que pertenece el bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo AssetType
     */
    public function asset_type()
    {
        return $this->belongsTo(AssetType::class);
    }
    
    /**
     * Método que obtiene la categoria a la que pertenece el bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo AssetCategory
     */
    public function asset_category()
    {
        return $this->belongsTo(AssetCategory::class);
    }

    /**
     * Método que obtiene la subcategoria a la que pertenece el bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo AssetSubcategory
     */
    public function asset_subcategory()
    {
        return $this->belongsTo(AssetSubcategory::class);
    }

    /**
     * Método que obtiene la categoria específica a la que pertenece el bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo AssetSpecificCategory
     */

    public function asset_specific_category()
    {
        return $this->belongsTo(AssetSpecificCategory::class);
    }

    /**
     * Método que obtiene el tipo de adquisicion del bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo AssetAcquisitionType
     */
    public function asset_acquisition_type()
    {
        return $this->belongsTo(AssetAcquisitionType::class);
    }

    /**
     * Método que obtiene la condición física del bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo AssetCondition
     */
    public function asset_condition()
    {
        return $this->belongsTo(AssetCondition::class);
    }

    /**
     * Método que obtiene el estatus de uso del bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo AssetStatus
     */
    public function asset_status()
    {
        return $this->belongsTo(AssetStatus::class);
    }

    /**
     * Método que obtiene la función de uso del bien
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo Objeto con el registro relacionado al modelo AssetUseFunction
     */
    public function asset_use_function()
    {
        return $this->belongsTo(AssetUseFunction::class);
    }

    /**
     * Método que obtiene los bienes asignados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne Objeto con el registro relacionado al modelo AssetAsignationAsset
     */

    public function asset_asignation_asset()
    {
        return $this->hasOne(AssetAsignationAsset::class);
    }

    /**
     * Método que obtiene los bienes desincorporados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne Objeto con el registro relacionado al modelo AssetDisincorporationAsset
     */
    public function asset_disincorporation_asset()
    {
        return $this->hasOne(AssetDisincorporationAsset::class);
    }

    /**
     * Método que obtiene los bienes solicitados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasOne Objeto con el registro relacionado al modelo AssetRequestAsset
     */
    public function asset_request_asset()
    {
        return $this->hasOne(AssetRequestAsset::class);
    }

    /**
     * Método que obtiene los bienes inventariados
     *
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\HasMany Objeto con el registro relacionado al modelo AssetInventoryAsset
     */
    public function asset_inventory_assets()
    {
        return $this->hasMany(AssetInventoryAsset::class);
    }

    /**
     * Método que obtiene la parroquia donde esta ubicado el bien
     * 
     * @author Henry Paredes <hparedes@cenditel.gob.ve>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parish()
    {
        return $this->belongsTo(\App\Models\Parish::class);
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
        if($type != "") {
            if ($category != "") {
                if ($subcategory != "") {
                    if ($specific != "") {
                        return $query->where('asset_type_id',$type)
                                     ->where('asset_category_id',$category)
                                     ->where('asset_subcategory_id',$subcategory)
                                     ->where('asset_specific_category_id',$specific);
                    }
                    return $query->where('asset_type_id',$type)
                             ->where('asset_category_id',$category)
                              ->where('asset_subcategory_id',$subcategory);
                }
                return $query->where('asset_type_id',$type)
                             ->where('asset_category_id',$category);
            }
            return $query->where('asset_type_id',$type);
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
                return $query->whereBetween("created_at",[$start,$end]); 
            }
            else {
                return $query->whereBetween("created_at",[$start,now()]);
            }
        }

        if (!is_null($mes)) {
            if (!is_null($year)) {
                return $query->whereMonth('created_at', $mes)
                             ->whereYear('created_at', $year);
            }else
                return $query->whereMonth('created_at', $mes);
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
