<?php

namespace Modules\Budget\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class BudgetAccount extends Model
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
    	'group', 'generic', 'specific', 'subspecific', 'denomination', 'active', 'resource',
    	'egress', 'tax_id', 'parent_id'
    ];


}
