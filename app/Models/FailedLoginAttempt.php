<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;
use App\Traits\ModelsTrait;

class FailedLoginAttempt extends Model implements Auditable
{
    use AuditableTrait;
    use ModelsTrait;

    protected $fillable = [
        'user_id', 'username', 'ip',
    ];

    /**
     * Registra los datos del intento fallido de autenticación en el sistema
     *
     * @method     record
     *
     * @author     Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
     *
     * @param      string           $username    Nombre del usuario utilizado para él acceso al sistema
     * @param      string           $ip          Dirección IP desde donde se intentó acceder al sistema
     * @param      object|null      $user        Objeto que contiene información del usuario
     *
     * @return     object           Devuelve un objeto con los datos del intento fallido
     */
    public static function record($username, $ip, $user = null)
    {
        return static::create([
            'user_id' => is_null($user) ? null : $user->id,
            'username' => $username,
            'ip' => $ip,
        ]);
    }

    /**
     * FailedLoginAttempt belongs to User.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
