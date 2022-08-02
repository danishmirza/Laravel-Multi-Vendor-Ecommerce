<?php

namespace App\Notifications;

use App\Notifications\Channels\CustomBroadcastChannel;
use App\Notifications\Channels\FCMChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NewMessageNotification extends Notification
{
    use Queueable;
    private $message;
    private $receiverId;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($message, $receiverId)
    {
        $this->message = $message;
        $this->receiverId = $receiverId;
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
            return [CustomBroadcastChannel::class];
        }
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
            'title' => ['en' => 'New Message', 'ar' => 'New Message'],
            'detail' => ['en' => 'You received a new message', 'ar' => 'You received a new message'],
            'action' => 'NEW_MESSAGE',
            'extras' => ['conversation_id' => $this->message->conversation_id, ]
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'message' => $this->message
        ];
    }

    public function channelName($notifiable){
        return [
            'click-shine-chat-message-'.$notifiable->id,
            'click-shine-new-message-'.$notifiable->id,
            'click-shine-new-notification-'.$notifiable->id,
        ];
    }

    public function broadcastAs(){
        return 'new-message';
    }

    public function toFCM($notifiable){
        $tokens = $notifiable->fcmTokens->pluck('fcm_token');
        return [
            'registration_ids' => $tokens,
            'notification' =>  [
                'title' => 'New Chat Message',
                'body' => 'You received bew chat message',
                'sound' => 'default',
            ],
            'priority' => 'high'
        ];
    }
}
