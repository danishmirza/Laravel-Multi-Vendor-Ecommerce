<?php

namespace App\Notifications;

use App\Notifications\Channels\CustomBroadcastChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CartChangedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [CustomBroadcastChannel::class];
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function channelName($notifiable){
        return [
            'click-shine-cart-changed-'.$notifiable->id,
        ];
    }

    public function broadcastAs(){
        return 'cart-changed';
    }
}
