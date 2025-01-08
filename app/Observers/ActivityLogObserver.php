<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogObserver
{
    public function created($model)
    {
        if (!Auth::check()) {
            return;
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'type' => 'model_created',
            'description' => class_basename($model) . ' created',
            'metadata' => [
                'model' => get_class($model),
                'id' => $model->id,
                'attributes' => $model->getAttributes(),
            ],
        ]);
    }

    public function updated($model)
    {
        if (!Auth::check()) {
            return;
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'type' => 'model_updated',
            'description' => class_basename($model) . ' updated',
            'metadata' => [
                'model' => get_class($model),
                'id' => $model->id,
                'changes' => $model->getChanges(),
                'original' => $model->getOriginal(),
            ],
        ]);
    }

    public function deleted($model)
    {
        if (!Auth::check()) {
            return;
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'type' => 'model_deleted',
            'description' => class_basename($model) . ' deleted',
            'metadata' => [
                'model' => get_class($model),
                'id' => $model->id,
                'attributes' => $model->getAttributes(),
            ],
        ]);
    }

    public function restored($model)
    {
        if (!Auth::check()) {
            return;
        }

        ActivityLog::create([
            'user_id' => Auth::id(),
            'type' => 'model_restored',
            'description' => class_basename($model) . ' restored',
            'metadata' => [
                'model' => get_class($model),
                'id' => $model->id,
                'attributes' => $model->getAttributes(),
            ],
        ]);
    }
}