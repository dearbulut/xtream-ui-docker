<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActivityLogExportCompleted extends Notification
{
    use Queueable;

    protected $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/storage/exports/' . $this->filename);

        return (new MailMessage)
            ->subject('Activity Log Export Completed')
            ->line('Your activity log export has been completed.')
            ->action('Download Export', $url)
            ->line('The file will be available for download for the next 24 hours.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'activity_log_export',
            'message' => 'Activity log export completed',
            'filename' => $this->filename,
            'url' => url('/storage/exports/' . $this->filename),
        ];
    }
}
