<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class Asset extends Model
{
    use SoftDeletes;
    use RevisionableTrait;
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
        'type_id', 'category_id', 'subcategory_id', 'specific_category_id', 'institucion_id', 'proveedor_id', 'condition', 'purchase_id', 'status', 'purchase_year', 'serial', 'marca', 'modelo', 'serial_inventario',' value', 'orden_compra_id', 'ubicacion_id'
    ];

     /**
     * Construye un arreglo de elementos para usar en palntillas blade
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return [array] Arreglo con los registros
     */
     public static function template_choices()
    {
        $options = [];
        foreach (self::all() as $reg) {
            $options[$reg->id] = $reg->name;
        }
        return $options;
    }


}
