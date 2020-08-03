<?php

namespace Modules\DigitalSignature\Models;

use Modules\DigitalSignature\Models\Signprofile;
use App\User as BaseUser;

class User extends BaseUser
{
   public function signprofiles() 
   {
        return $this->hasOne(Signprofile::class);
   }
}
