<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @class Session
 * @brief Datos de Sesiones
 * 
 * Gestiona el modelo de datos para las sesiones del sistema
 * 
 * @author Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
 * @copyright <a href='http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/'>LICENCIA DE SOFTWARE CENDITEL</a>
 */
class Session extends Model
{
    /**
     * Método que obtiene los datos de sessión del usuario autenticado
     *
     * @author  Ing. Roldan Vargas (rvargas@cenditel.gob.ve)
     * @param integer $user_id Identificador del usuario 
     * @return mixed          Objeto con los datos de la sessión activa del usuario autenticado en el sistema
     */
    public static function getSessionData($user_id)
    {
        $session = DB::table('sessions')->where('user_id', $user_id)->first();

        return $session;
    }
}
