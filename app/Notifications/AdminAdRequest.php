<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdminAdRequest extends Notification implements ShouldQueue
{
    use Queueable;

    private $storeId;
    private $adId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($storeId, $adId)
    {
        $this->storeId = $storeId;
        $this->adId = $adId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            //
        ];
    }

    public function toDatabase($notifiable){
        return [
            'is_admin' => 'true',
            'title' => 'New Ad request generated',
            'detail' => 'Service provided have generated a new ad request',
            'adId' => $this->adId,
            'storeId' => $this->storeId,
        ];
    }

    public function withDelay($notifiable)
    {
        return [
            'database' => now()->addSeconds(3),
        ];
    }
}
