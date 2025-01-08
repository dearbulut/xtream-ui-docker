<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityLogsCleanedUp implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $count;
    public $days;

    public function __construct(int $count, int $days)
    {
        $this->count = $count;
        $this->days = $days;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('activity-logs');
    }

    public function broadcastAs()
    {
        return 'activity-logs.cleaned-up';
    }

    public function broadcastWith()
    {
        return [
            'count' => $this->count,
            'days' => $this->days,
            'message' => "{$this->count} activity logs older than {$this->days} days have been cleaned up.",
        ];
    }
}