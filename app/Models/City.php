<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class City extends Model
{
    use SoftDeletes;
    use RevisionableTrait;
    protected $revisionCreationsEnabled = true;

    /**
     * Los atributos que pueden ser convertidos a fechas
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Los atributos que pueden ser asignados masivamente
     *
     * @var array
     */
    protected $fillable = ['name', 'estate_id'];

    /**
     * Método que obtiene el Estado de una Ciudad
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return [type] [description]
     */
	public function estate()
    {
        return $this->belongsTo('App\Models\Estate', 'estate_id');
    }

    /**
     * Método que genera un listado de opciones a implementar en elementos tipo select
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return [type] [description]
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
