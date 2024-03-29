<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewPostSearch extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The description of the notification.
     *
     * @var string
     */
    public $subject;

    /**
     * The url of the notification.
     *
     * @var string
     */
    public $posts;

    /**
     * Number of posts retrieved
     *
     * @var int
     */
    public $count;

    /**
     * Create a new notification instance.
     *
     * @param array $ids
     * @param int $count
     */
    public function __construct(array $ids = [], int $count = 0)
    {
        $this->subject = 'A new post search occurred!';
        $this->posts = $ids;
        $this->count = $count;
    }

    public function via($notifiable)
    {
        return [CustomDatabaseNotificationChannel::class];
    }

    public function toDatabase($notifiable)
    {
        return [
            'data' => $this->posts,
            'count' => $this->count
        ];
    }
}
