<?php

namespace App\Notifications;

use App\Notifications\Channels\CustomBroadcastChannel;
use App\Notifications\Channels\FCMChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AdRequestStatusChanged extends Notification implements ShouldQueue
{
    use Queueable;

    public $status;
    public $id1;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($status, $id)
    {
        $this->status = $status;
        $this->id1 = $id;
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

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }

    public function toDatabase($notifiable){
        $data = [
            'title' => ['en' => 'Ad Request approved', 'ar' => 'Ad Request approved'],
            'detail' => ['en' => 'Your ad request was approved', 'ar' => 'Your ad request was approved'],
            'action' => 'AD_REQUEST_STATUS',
            'extras' => ['status' => $this->status, 'id' => $this->id1]
        ];
        if($this->status == 'completed'){
            $data = [
                'title' => ['en' => 'Ad Request completed', 'ar' => 'Ad Request completed'],
                'detail' => ['en' => 'Your ad request was completed', 'ar' => 'Your ad request was completed'],
                'action' => 'AD_REQUEST_STATUS',
                'extras' => ['status' => $this->status, 'id' => $this->id1]
            ];
        }
        if($this->status == 'rejected'){
            $data = [
                'title' => ['en' => 'Ad Request rejected', 'ar' => 'Ad Request rejected'],
                'detail' => ['en' => 'Your ad request was rejected', 'ar' => 'Your ad request was rejected'],
                'action' => 'AD_REQUEST_STATUS',
                'extras' => ['status' => $this->status, 'id' => $this->id1]
            ];
        }
        return $data;
    }

//    public function withDelay($notifiable)
//    {
//        return [
//            'database' => now()->addSeconds(3),
//        ];
//    }

    public function channelName($notifiable){
        return [
            'click-shine-new-notification-'.$notifiable->id,
        ];
    }

    public function broadcastAs(){
        return 'new-notification';
    }

    public function toFCM($notifiable){
        $data = $this->toDatabase($notifiable);
        $tokens = $notifiable->fcmTokens->pluck('fcm_token');
        return [
            'registration_ids' => $tokens,
            'notification' =>  [
                'title' => $data['title']['en'],
                'body' => $data['detail']['en'],
                'sound' => 'default',
            ],
            'priority' => 'high'
        ];
    }
}
