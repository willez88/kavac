<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class Municipality extends Model
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
    protected $fillable = ['name', 'code', 'estate_id'];

    /**
     * Get the Country of the State
     */
	public function estate()
    {
        return $this->belongsTo('App\Models\Estate', 'estate_id');
    }

    /**
     * Get the Parishes for the Municipality.
     */
    public function parish()
    {
    	return $this->hasMany('App\Models\Parish');
    }

    /**
     * Select choices for template uses
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
