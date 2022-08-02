<?php

namespace App\Notifications\Channels;

use App\Events\CustomBroadcastNotificationCreated;
use Illuminate\Notifications\Channels\BroadcastChannel;
use Illuminate\Notifications\Notification;


class CustomBroadcastChannel extends BroadcastChannel
{
    public function send($notifiable, Notification $notification)
    {
        $message = $this->getData($notifiable, $notification);
        $event = new CustomBroadcastNotificationCreated(
            $notifiable, $notification, is_array($message) ? $message : $message->data
        );
        return event($event);
    }
}