<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActivityLogsCleanupCompleted extends Notification implements ShouldQueue
{
    use Queueable;

    public $count;
    public $days;

    public function __construct(int $count, int $days)
    {
        $this->count = $count;
        $this->days = $days;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Activity Logs Cleanup Completed')
            ->line("{$this->count} activity logs older than {$this->days} days have been cleaned up.")
            ->action('View Activity Logs', url('/activity-logs'));
    }

    public function toArray($notifiable)
    {
        return [
            'count' => $this->count,
            'days' => $this->days,
            'message' => "{$this->count} activity logs older than {$this->days} days have been cleaned up.",
        ];
    }
}