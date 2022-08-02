<?php


namespace App\Notifications\Channels;


use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FCMChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $this->getData($notifiable, $notification);
        return $this->pushFCMNotification($data);
    }

    protected function getData($notifiable, Notification $notification)
    {
        if (method_exists($notification, 'toFCM')) {
            return $notification->toFCM($notifiable);
        }
        throw new \RuntimeException('Notification is missing toArray method.');
    }

    public function pushFCMNotification($fields)
    {
        $response = Http::withHeaders([
            'Authorization' => 'key=' . env('FCM_SERVER_KEY')
        ])->post(env('FCM_SERVER_URL'), $fields);
        $body =  $response->body();
        Log::channel('custom')->info("FCM Message =>",[$body]);
        return $body;
    }

}