<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Session extends Model
{
    /**
     * Obtiene la sesión de un usuario
     * @param  [integer] $user_id Identificador del usuario
     * @return [Object]           Objeto con los datos del usuario
     */
    public static function getSessionData($user_id)
    {
        $session = DB::table('sessions')->where('user_id', $user_id)->first();

        return $session;
    }
}
