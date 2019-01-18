<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

class AssetRequestEvent extends Model
{
    protected $fillable = ['type','description','request_id'];

    public function request()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetRequest', 'request_id');
    }
}
