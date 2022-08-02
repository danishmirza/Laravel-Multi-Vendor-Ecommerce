<?php

namespace App\Notifications;

use App\Notifications\Channels\CustomBroadcastChannel;
use App\Notifications\Channels\FCMChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CancelledOrderNotification extends Notification
{
    use Queueable;

    private $orderId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($orderId)
    {
        $this->orderId = $orderId;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        if($notifiable->isNotificationEnabled()){
            return ['database', CustomBroadcastChannel::class, FCMChannel::class];
        }else{
            return [];
        }
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
            'title' => ['en' => 'Order Cancelled', 'ar' => 'Order Cancelled'],
            'detail' => ['en' => 'Your order was cancelled by provider', 'ar' => 'Your order was cancelled by provider'],
            'action' => 'ORDER_CANCELLED',
            'extras' => ['orderId' => $this->orderId, 'status' =>'cancelled' ]
        ];
    }


    public function channelName($notifiable){
        return [
            'click-shine-new-notification-'.$notifiable->id,
        ];
    }

    public function broadcastAs(){
        return 'new-notification';
    }

    public function toFCM($notifiable){
        $tokens = $notifiable->fcmTokens->pluck('fcm_token');
        return [
            'registration_ids' => $tokens,
            'notification' =>  [
                'title' => 'Order Cancelled',
                'body' => 'Your order was cancelled by the service provider',
                'sound' => 'default',
            ],
            'priority' => 'high'
        ];
    }
}
