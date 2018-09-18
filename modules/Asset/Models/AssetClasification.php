<?php

namespace Modules\Asset\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class AssetClasification extends Model
{
    
	use SoftDeletes;
    use RevisionableTrait;
    protected $revisionCreationsEnabled = true;
    
	protected $fillable = ['id'];
	protected $dates = ['deleted_at']; 
}
