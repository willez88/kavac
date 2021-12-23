<?php
/** Notificaciones del módulo de comercialización */
namespace Modules\Sale\Notifications;;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

/**
 * @class BillApproved
 * @brief Notificaciones de factura aprobada
 *
 * Gestiona las Notificaciones al aprobar una factura
 *
 * @author Daniel Contreras <dcontreras@cenditel.gob.ve>
 *
 * @license
 *     [LICENCIA DE SOFTWARE CENDITEL](http://conocimientolibre.cenditel.gob.ve/licencia-de-software-v-1-3/)
 */
class BillApproved extends Notification //implements ShouldQueue
{
    use Queueable;

    /** @var User Objeto con información del usuario registrado */
    public $user;

    /** @var User Objeto con información de la factura aprobada */
    public $bill;

    /**
     * Create a new notification instance.
     *
     * @method  __construct
     *
     * @return void
     */
    public function __construct(User $user, $auth_user, $bill)
    {
        $this->user = $user;
        $this->auth_user = $auth_user;
        $this->bill = $bill;
        $this->notifyTitle = __('Factura aprobada');
        $this->notifyMessage = __('Se ha aprobado una factura');
    }

    /**
     * Get the notification's delivery channels.
     *
     * @method  via
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @method  toMail
     *
     * @param  mixed  $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from(config('mail.from.address'), config('mail.from.name'))
                    ->subject(config('app.name') . ' - ' . __('Factura aprobada'))
                    ->greeting(__('Estimado(a) :username', ['username' => $this->auth_user->username]))
                    ->line(
                        __('El usuario :auth_username', ['auth_username' => $this->user->username])
                    )
                    ->line(__('ha aprobado la factura :bill', ['bill' => $this->bill->code]))
                    ->line(__('Para detallar la factura, pulse a continuación'))
                    ->action(__('Factura'), url('/sale/bills/pdf/'.$this->bill->id))
                    ->line(__(
                        'Este correo es enviado de manera automática por la aplicación y no esta siendo monitoreado. ' .
                        'Por favor no responda a este correo!'
                    ));
    }

    /**
     * Get the array representation of the notification.
     *
     * @method  toArray
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->notifyTitle,
            'module' => null,
            'message' => $this->notifyMessage,
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @method  toDatabase
     *
     * @param  mixed  $notifiable
     *
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->notifyTitle,
            'module' => null,
            'message' => $this->notifyMessage,
        ];
    }
}
