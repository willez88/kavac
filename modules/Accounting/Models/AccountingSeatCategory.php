<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingSeatCategory extends Model
{
    protected $fillable = ['name','acronym'];

    /**
     * AccountingSeatCategory has one AccountingSeat.
     *
     * @author  Juan Rosas <JuanFBass17@gmail.com>
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function accounting_seats()
    {
        return $this->hasMany(AccountingSeat::class, 'generated_by_id');
    }

}
