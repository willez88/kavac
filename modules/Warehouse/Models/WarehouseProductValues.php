<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseProductValues extends Model
{
    protected $fillable = ['value','attribute_id','inventary_id'];


    /**
     * Método que obtiene el atributo relacionado con el registro
     *
     * @author Henry Paredes (henryp2804@gmail.com)
     * @return Objeto con el registro relacionado al modelo WarehouseProductAttribute
     */

    public function atributte()
    {
    	return $this->belongsTo('Modules\Warehouse\Models\WarehouseProductAttribute','attribute_id');
    }


}
