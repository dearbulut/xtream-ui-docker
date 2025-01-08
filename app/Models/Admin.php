<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Traits\HasPermissions;
use App\Notifications\ActivityLogNotification;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasRoles, HasPermissions;

    protected $fillable = [
        'username',
        'password',
        'email',
        'name',
        'is_active',
        'permissions',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'permissions' => 'array',
        'is_active' => 'boolean',
    ];

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class, 'user_id');
    }

    public function routeNotificationForMail()
    {
        return $this->email;
    }

    public function notifications()
    {
        return $this->morphMany(\Illuminate\Notifications\DatabaseNotification::class, 'notifiable');
    }

    public function routeNotificationForDatabase()
    {
        return $this->notifications();
    }

    public function receivesBroadcastNotificationsOn()
    {
        return 'admins.' . $this->id;
    }

    public function shouldNotifyOnActivityLog(): bool
    {
        return $this->hasRole('admin') || $this->hasRole('super-admin');
    }
}