<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;

class SystemNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $title;
    public $details;
    public $currentTimestamp;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title, $details, $currentTimestamp = null)
    {
        $this->title = $title;
        $this->details = $details;
        $this->currentTimestamp = $currentTimestamp ?? \Carbon\Carbon::now()->toDateString();
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
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
            'message' => $this->details,
            'currentTimestamp' => $this->currentTimestamp
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->details,
            'currentTimestamp' => $this->currentTimestamp
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'title' => $this->title,
            'message' => $this->details,
            'currentTimestamp' => $this->currentTimestamp
        ]);
    }
}
