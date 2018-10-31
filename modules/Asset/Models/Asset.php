<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

/**
 * @class Asset
 * @brief Datos de los Bienes Institucionales
 * 
 * Gestiona el modelo de datos para los Bienes Institucionales
 * 
 * @author Henry Paredes (henryp2804@gmail.com)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */

class Asset extends Model
{
    use SoftDeletes;
    use RevisionableTrait;

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

    /**
     * Lista de atributos que pueden ser asignados masivamente
     * @var array $fillable
     */
    protected $fillable = [
        'orden_compra', 'type_id', 'category_id', 'subcategory_id', 'specific_category_id', 'institution_id', 'proveedor_id','condition_id','purchase_id','purchase_year','status_id', 'serial', 'marca',
        'model', 'serial_inventario', 'value','use_id','quantity'
    ];

    /**
     * Método que permite obtener el Serial de Inventario de un Bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return [string] Retorna el Serial de Inventario de un Bien
     */
    public function getCode()
    {
        $code = $this->type_id .'-'. $this->category_id .'-'. $this->subcategory_id .'-'. $this->specific_category_id .'-'. $this->purchase_year;

        return $code;
    }

    public function getDescription()
    {
        $description = 'Código: '.$this->getCode() .'. Marca: '. $this->marca .'. Modelo: '. $this->model;
        if ($this->type_id == 2){
            $description = $description . ". Serial: ". $this->serial;
        }
        return $description;
    }
    
    /**
     * Método que obtiene el tipo al que pertenece el bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetCategory
     */
    public function type()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetType', 'type_id');
    }
    
    /**
     * Método que obtiene la categoria a la que pertenece el bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetCategory
     */
    public function category()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetCategory', 'category_id');
    }

    /**
     * Método que obtiene la subcategoria a la que pertenece el bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetCategory
     */
    public function subcategory()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetSubcategory', 'subcategory_id');
    }

    /**
     * Método que obtiene la categoria específica a la que pertenece el bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetCategory
     */
    public function specific()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetSpecificCategory', 'specific_category_id');
    }

    /**
     * Método que obtiene la forma de adquisicion del bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetCategory
     */
    public function purchase()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetPurchase', 'purchase_id');
    }

    /**
     * Método que obtiene la condición física del bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetCategory
     */
    public function condition()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetCondition', 'condition_id');
    }

    /**
     * Método que obtiene el Staus de uso del bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetCategory
     */
    public function status()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetStatus', 'status_id');
    }

    /**
     * Método que obtiene la Función de uso del bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetCategory
     */
    public function use()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetUse', 'use_id');
    }

    /**
     * Método que obtiene el tipo al que pertenece el bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetCategory
     */
    public function asig()
    {
        return $this->hasMany('Modules\Asset\Models\AssetAsignation');
    }

    /**
     * Método que obtiene el tipo al que pertenece el bien
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo AssetCategory
     */
    public function disasig()
    {
        return $this->hasMany('Modules\Asset\Models\AssetDisincorporation');
    }



    /**
     *
     * @brief Método que genera un listado de elementos registrados para ser implementados en plantillas blade
     * 
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return [array] Listado de bienes
     */
     public static function template_choices($filters = [])
    {
        $records = self::all();
        if ($filters) {
            foreach ($filters as $key => $value) {
                $records = $records->where($key, $value);
            }
        }
        $options = [];
        foreach ($records as $rec) {
            $options[$rec->id] = $rec->getDescription();
        }
        return $options;
    }


    public function scopeCodeClasification($query, $type, $category, $subcategory, $specific){
        if($type != ""){
            if ($category != "") {
                if ($subcategory != "") {
                    if ($specific != "") {
                        return $query->where('type_id',$type)
                                     ->where('category_id',$category)
                                     ->where('subcategory_id',$subcategory)
                                     ->where('specific_category_id',$specific);
                    }
                    return $query->where('type_id',$type)
                             ->where('category_id',$category)
                              ->where('subcategory_id',$subcategory);
                }
                return $query->where('type_id',$type)
                             ->where('category_id',$category);
            }
            return $query->where('type_id',$type);
        }
    }

    public function scopeDateClasification($query, $start, $end){
        
        if (!is_null($start)){
            if (!is_null($end)){
                return $query->whereBetween("created_at",[$start,$end]); 
            }
            else{
                return $query->whereBetween("created_at",[$start,now()]);
            }
        }
        
    }

    public function scopeRequest($query, $model, $marca, $serial){
        if(trim($serial) != ""){
            if(trim($marca) != ""){
                if(trim($model) != ""){
                    $query->where('serial','like',"%$serial%")
                          ->where('marca','like',"%$marca%")
                          ->where('model','like',"%$model%");   
                }
                $query->where('serial','like',"%$serial%")
                      ->where('marca','like',"%$marca%");
            }
            if(trim($model) != ""){
                    $query->where('serial','like',"%$serial%")
                          ->where('marca','like',"%$marca%")
                          ->where('model','like',"%$model%");   
            }
            $query->where('serial','like',"%$serial%");
        }
        else if(trim($marca) != ""){
            if(trim($model) != ""){
                if(trim($serial) != ""){
                    $query->where('marca','like',"%$marca%")
                          ->where('model','like',"%$model%")
                          ->where('serial','like',"%serial%");

                }
                $query->where('marca','like',"%$marca%")
                      ->where('model','like',"%$model%");
            }
            if(trim($serial) != ""){
                    $query->where('marca','like',"%$marca%")
                          ->where('model','like',"%$model%")
                          ->where('serial','like',"%serial%");

            }
            $query->where('marca','like',"%$marca%");
        }
        else if(trim($model) != ""){
            if(trim($serial) != ""){
                if(trim($marca) != ""){
                    $query->where('model','like',"%$model%")
                          ->where('serial','like',"%serial%")
                          ->where('marca','like',"%$marca%");

                }
                $query->where('model','like',"%$model%")
                      ->where('serial','like',"%$serial%");
            }
            if(trim($marca) != ""){
                    $query->where('model','like',"%$model%")
                          ->where('serial','like',"%serial%")
                          ->where('marca','like',"%$marca%");

            }
            $query->where('model','like',"%$model%");
        }
    }


}
