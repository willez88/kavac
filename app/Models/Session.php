<?php

/** Modelos generales de base de datos */
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * @class Session
 * @brief Datos de Sesiones
 *
 * Gestiona el modelo de datos para las sesiones del sistema
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class Session extends Model
{
    /**
     * Método que obtiene los datos de sessión del usuario autenticado
     *
     * @method  getSessionData
     *
     * @author  Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param integer $user_id Identificador del usuario
     *
     * @return mixed          Objeto con los datos de la sessión activa del usuario autenticado en el sistema
     */
    public static function getSessionData($user_id)
    {
        $session = DB::table('sessions')->where('user_id', $user_id)->first();

        return $session;
    }
}
