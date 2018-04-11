<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class Tax extends Model
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
    	'name', 'description', 'affect_tax', 'active'
    ];

    /**
     * Método que obtiene los históricos de los impuestos
     *
     * @author  Ing. Roldan Vargas <rvargas at cenditel.gob.ve>
     * @return [type] [description]
     */
    public function histories()
    {
        return $this->hasMany('App\Models\HistoryTax');
    }
}
