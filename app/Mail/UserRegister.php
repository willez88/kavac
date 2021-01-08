<?php
/** Gestión correos del sistema */
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\User;

/**
 * @class UserRegister
 * @brief Gestiona los correos de notificación de usuarios registrados
 *
 * Gestiona los correos de notificación de usuarios registrados
 *
 * @author Ing. Roldan Vargas <rvargas@cenditel.gob.ve> | <roldandvg@gmail.com>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class UserRegister extends Mailable
{
    use Queueable, SerializesModels;

    /** @var User Objeto con información del usuario */
    public $user;
    /** @var string Contraseña de acceso generada por el sistema */
    public $password;
    /** @var string Nombre de la aplicación */
    public $appName;
    /** @var string URL de la aplicación */
    public $appUrl;

    /**
     * Crea una nueva instancia del mensaje.
     *
     * @method  __construct
     *
     * @return void
     */
    public function __construct(User $user, $password)
    {
        $this->user = $user;
        $this->password = $password;
        $this->appName = config('app.name');
        $this->appUrl = config('app.url');
    }

    /**
     * Construye el mensaje.
     *
     * @method  build
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject(config('app.name') . " - Registro")->markdown('emails.user-register');
    }
}
