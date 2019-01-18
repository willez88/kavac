<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;

class AssetRequestProrroga extends Model
{
    protected $fillable = ['date','state','request_id'];

    public function request()
    {
        return $this->belongsTo('Modules\Asset\Models\AssetRequest', 'request_id');
    }
}
