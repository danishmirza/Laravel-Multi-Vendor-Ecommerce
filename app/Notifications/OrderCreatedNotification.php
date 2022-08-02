<?php

namespace App\Notifications;

use App\Notifications\Channels\CustomBroadcastChannel;
use App\Notifications\Channels\FCMChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;
    private $orderId;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($orderId, $userType)
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
            'title' => ['en' => 'New Order Created', 'ar' => 'New Order Created'],
            'detail' => ['en' => 'New order is created successfully', 'ar' => 'New order is created successfully'],
            'action' => 'ORDER_CREATED',
            'extras' => ['orderId' => $this->orderId, 'status' =>'confirmed' ]
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
                'title' => 'New Order Created',
                'body' => 'New order is created successfully',
                'sound' => 'default',
            ],
            'priority' => 'high'
        ];
    }
}
