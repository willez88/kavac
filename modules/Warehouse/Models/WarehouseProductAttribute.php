<?php

namespace Modules\Warehouse\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseProductAttribute extends Model
{
    protected $fillable = ['name','product_id'];


    public function product()
    {
    	return $this->belongsTo('Modules\Warehouse\Models\WarehouseProduct','product_id');
    }
    public function value()
    {
    	return $this->hasOne('Modules\Warehouse\Models\WarehouseProductValues','attribute_id');
    }
}
