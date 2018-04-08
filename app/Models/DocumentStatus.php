<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use \Venturecraft\Revisionable\RevisionableTrait;

class DocumentStatus extends Model
{
    use SoftDeletes;
    use RevisionableTrait;
    protected $revisionCreationsEnabled = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'document_status';

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
    protected $fillable = ['name', 'description', 'color'];
}
