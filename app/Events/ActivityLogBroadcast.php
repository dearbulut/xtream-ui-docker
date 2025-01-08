<?php

namespace App\Events;

use App\Models\ActivityLog;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ActivityLogBroadcast implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $activityLog;

    public function __construct(ActivityLog $activityLog)
    {
        $this->activityLog = $activityLog;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('activity-logs'),
        ];
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->activityLog->id,
            'type' => $this->activityLog->type,
            'description' => $this->activityLog->description,
            'user' => $this->activityLog->user ? [
                'id' => $this->activityLog->user->id,
                'name' => $this->activityLog->user->name,
                'email' => $this->activityLog->user->email,
            ] : null,
            'created_at' => $this->activityLog->created_at->toIso8601String(),
        ];
    }
}
