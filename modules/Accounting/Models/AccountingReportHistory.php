<?php

namespace Modules\Accounting\Models;

use Illuminate\Database\Eloquent\Model;

class AccountingReportHistory extends Model
{
    /**
     * Fields that can be mass assigned.
     *
     * @var array
     */
    protected $fillable = ['report','url','name'];
}
