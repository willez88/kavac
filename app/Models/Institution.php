<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class Institution extends Model
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
    	'onapre_code', 'rif', 'acronym', 'name', 'business_name', 'start_operations_date', 'legal_base',
    	'legal_form', 'main_activity', 'mission', 'vision', 'legal_address', 'web', 'composition_assets',
    	'postal_code', 'active', 'default', 'retention_agent', 'institution_sector_id', 'institution_type_id',
    	'municipality_id', 'city_id', 'logo_id', 'banner_id'
    ];

    /**
     * Get the Logo image of the Institution
     */
    public function logo()
    {
        return $this->belongsTo('App\Models\Image', 'logo_id');
    }

    /**
     * Get the Banner image of the Institution
     */
    public function banner()
    {
        return $this->belongsTo('App\Models\Image', 'banner_id');
    }
}
