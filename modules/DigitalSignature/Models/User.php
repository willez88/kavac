<?php

namespace Modules\DigitalSignature\Models;

use App\Models\User as BaseUser;

class User extends BaseUser
{
    public function signprofiles()
    {
        return $this->hasOne(Signprofile::class);
    }
}
