<?php
/**
 * Created by PhpStorm.
 * User: User
 * Date: 3/23/2019
 * Time: 5:45 PM
 */
namespace App\Notifications;

use Illuminate\Notifications\Notification;

class CustomDatabaseNotificationChannel
{
    public function send($notifiable, Notification $notification)
    {
        $data = $notification->toDatabase($notifiable);

        return $notifiable->routeNotificationFor('database')->create([
            'id' => $notification->id,
            'type' => get_class($notification),
            'data' => $data,
            'read_at' => time(),
            'count' => $data['count']
        ]);
    }
}