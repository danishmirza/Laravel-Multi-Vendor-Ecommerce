<?php

namespace App\Notifications;

use App\Notifications\Channels\CustomBroadcastChannel;
use App\Notifications\Channels\FCMChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class TestNotification extends Notification
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
        return [CustomBroadcastChannel::class, FCMChannel::class];
    }

    public function toBroadcast(){
        return [
          'test' => 1
        ];
    }

    public function channelName($notifiable){
        Log::channel('custom')->info('Notifiable',[$notifiable]);
        return ['click-shine-new-notification-19'];
    }

    public function broadcastAs(){
        return '.new-notification';
    }

    public function toFCM($notifiable){
        $tokens = $notifiable->fcmTokens->pluck('fcm_token');
        return [
            'registration_ids' => $tokens,
            'notification' =>  [
                'title' => 'Test Message',
                'body' => 'Test Message Body',
                'sound' => 'default',
            ],
            'priority' => 'high'
        ];
    }
}
