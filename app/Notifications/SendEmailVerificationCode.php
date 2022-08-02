<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SendEmailVerificationCode extends Notification implements ShouldQueue
{
    use Queueable;

    private $code;
    private $receiverName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($code, $receiverName)
    {
        $this->code = $code;
        $this->receiverName = $receiverName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
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
            ->from(env('mail_from_address'))
            ->view('emails.web.email_verification', ['code' => $this->code, 'receiverName' => $this->receiverName])
            ->subject('Email Verification Code '.$this->code);
    }

    public function withDelay($notifiable)
    {
        return [
            'mail' => now()->addSeconds(5),
        ];
    }
}
