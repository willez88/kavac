<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SystemMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subjectMsg;
    public $messageText;
    public $fromEmail;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($subject, $message, $from = null)
    {
        $this->subjectMsg = $subject;
        $this->messageText = $message;
        $this->fromEmail = $from ?? config('mail.from.address');
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->fromEmail)->subject($this->subjectMsg)->markdown('emails.email');
    }
}
