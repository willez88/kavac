<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class System extends Notification //implements ShouldQueue
{
    use Queueable;

    protected $title;
    protected $module;
    protected $description;
    protected $notifyToEmail;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $module, $description, $notifyToEmail = false)
    {
        $this->title = $title;
        $this->module = $module;
        $this->description = $description;
        $this->notifyToEmail = $notifyToEmail;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return $this->notifyToEmail ? ['mail'] : ['database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'module' => $this->module,
            'description' => $this->description,
        ];
    }

    /**
     * Get the array representation of the notification
     *
     * @param   mixed $notifiable
     * @return  array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'module' => $this->module,
            'description' => $this->description,
        ];
    }
}
