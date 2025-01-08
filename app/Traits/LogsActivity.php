<?php

namespace App\Traits;

use App\Models\ActivityLog;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            static::logActivity($model, 'model_created');
        });

        static::updated(function ($model) {
            static::logActivity($model, 'model_updated');
        });

        static::deleted(function ($model) {
            static::logActivity($model, 'model_deleted');
        });

        if (method_exists(static::class, 'restored')) {
            static::restored(function ($model) {
                static::logActivity($model, 'model_restored');
            });
        }
    }

    protected static function logActivity($model, $type)
    {
        if (!auth()->check()) {
            return;
        }

        $metadata = [
            'model' => get_class($model),
            'id' => $model->id,
            'attributes' => $model->getAttributes(),
        ];

        if ($type === 'model_updated') {
            $metadata['changes'] = $model->getChanges();
            $metadata['original'] = $model->getOriginal();
        }

        ActivityLog::create([
            'user_id' => auth()->id(),
            'type' => $type,
            'description' => class_basename($model) . ' ' . str_replace('model_', '', $type),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'metadata' => $metadata,
        ]);
    }
}