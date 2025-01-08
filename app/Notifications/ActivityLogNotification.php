<?php

namespace App\Notifications;

use App\Models\ActivityLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActivityLogNotification extends Notification
{
    use Queueable;

    protected $activityLog;

    public function __construct(ActivityLog $activityLog)
    {
        $this->activityLog = $activityLog;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/activity-logs');

        return (new MailMessage)
            ->subject('New Activity Log: ' . $this->activityLog->type)
            ->line('A new activity has been logged:')
            ->line('Type: ' . $this->activityLog->type)
            ->line('Description: ' . $this->activityLog->description)
            ->line('IP Address: ' . $this->activityLog->ip_address)
            ->action('View Activity Logs', $url);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => $this->activityLog->type,
            'description' => $this->activityLog->description,
            'ip_address' => $this->activityLog->ip_address,
            'user_agent' => $this->activityLog->user_agent,
            'metadata' => $this->activityLog->metadata,
        ];
    }
}
