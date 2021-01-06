<?php

/**
 * Registros de la aplicación
 */
namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use App\Roles\Traits\HasRoleAndPermission;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

/**
 * @class User
 * @brief Datos de Usuarios
 *
 * Gestiona el modelo de datos para las Usuarios
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class User extends Authenticatable implements Auditable, MustVerifyEmail
{
    use HasFactory, Notifiable, SoftDeletes, HasRoleAndPermission, AuditableTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'lock_screen', 'time_lock', 'blocked_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'last_login', 'blocked_at'];

    /**
     * User has many FailedLoginAttempts.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function failedLoginAttempts()
    {
        return $this->hasMany(FailedLoginAttempt::class);
    }

    /**
     * Método que obtiene el perfil de un usuario
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    /**
     * User belongs to Many NotificationSetting.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function notificationSettings()
    {
        return $this->belongsToMany(NotificationSetting::class)->withPivot('type')->withTimestamps();
    }

    /**
     * Envía la notificación por correo para el reestablecimiento de la contraseña
     *
     * @method    sendPasswordResetNotification
     *
     * @param     string    $token    Token de la URL para el acceso al formulario de reestablecimiento de contraseña
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Envía la notificación de verificación de usuario para poder acceder a la aplicación
     *
     * @method    sendEmailVerificationNotification
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmailNotification);
    }

    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return $this->getKey();
    }
}
