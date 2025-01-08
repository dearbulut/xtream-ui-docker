<?php

namespace App\Presenters;

use App\Models\ActivityLog;

class ActivityLogPresenter
{
    protected $activityLog;

    public function __construct(ActivityLog $activityLog)
    {
        $this->activityLog = $activityLog;
    }

    public function typeLabel(): array
    {
        $colors = [
            'login' => 'success',
            'logout' => 'info',
            'login_failed' => 'danger',
            'model_created' => 'primary',
            'model_updated' => 'warning',
            'model_deleted' => 'danger',
            'model_restored' => 'success',
        ];

        $labels = [
            'login' => 'Login',
            'logout' => 'Logout',
            'login_failed' => 'Failed Login',
            'model_created' => 'Created',
            'model_updated' => 'Updated',
            'model_deleted' => 'Deleted',
            'model_restored' => 'Restored',
        ];

        return [
            'text' => $labels[$this->activityLog->type] ?? $this->activityLog->type,
            'color' => $colors[$this->activityLog->type] ?? 'gray',
        ];
    }

    public function userInfo(): array
    {
        if (!$this->activityLog->user) {
            return [
                'name' => 'System',
                'email' => null,
                'avatar' => null,
            ];
        }

        return [
            'name' => $this->activityLog->user->name,
            'email' => $this->activityLog->user->email,
            'avatar' => $this->activityLog->user->avatar_url,
        ];
    }

    public function metadataFormatted(): ?array
    {
        if (!$this->activityLog->metadata) {
            return null;
        }

        $metadata = $this->activityLog->metadata;

        if (isset($metadata['model'])) {
            $metadata['model'] = class_basename($metadata['model']);
        }

        return $metadata;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->activityLog->id,
            'type' => $this->typeLabel(),
            'description' => $this->activityLog->description,
            'user' => $this->userInfo(),
            'ip_address' => $this->activityLog->ip_address,
            'user_agent' => $this->activityLog->user_agent,
            'metadata' => $this->metadataFormatted(),
            'created_at' => $this->activityLog->created_at->toIso8601String(),
            'time_ago' => $this->activityLog->created_at->diffForHumans(),
        ];
    }
}