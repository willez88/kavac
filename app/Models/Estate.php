<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class Estate extends Model
{
    use SoftDeletes;
    use RevisionableTrait;
    protected $revisionCreationsEnabled = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    //protected $table = 'common_states';

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
    protected $fillable = ['name', 'code', 'country_id'];

    /**
     * Get the Country of the State
     */
	public function country()
    {
        return $this->belongsTo(App\Models\Country::class, 'country_id');
    }

    /**
     * Get the Municipalities for the State.
     */
    public function municipalities()
    {
    	return $this->hasMany(App\Models\Municipality::class);
    }

    /**
     * Get the Cities for the State.
     */
    public function cities()
    {
        return $this->hasMany(App\Models\City::class);
    }
}
