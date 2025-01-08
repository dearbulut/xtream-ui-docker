<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\LogsActivity;

class Playlist extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        "name",
        "description",
        "user_id",
        "is_active",
        "expires_at",
        "max_connections",
        "allowed_ips",
        "notes",
    ];

    protected $casts = [
        "is_active" => "boolean",
        "expires_at" => "datetime",
        "max_connections" => "integer",
        "allowed_ips" => "array",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function channels()
    {
        return $this->belongsToMany(Channel::class);
    }

    public function movies()
    {
        return $this->belongsToMany(Movie::class);
    }

    public function series()
    {
        return $this->belongsToMany(Series::class);
    }

    public function bouquets()
    {
        return $this->belongsToMany(Bouquet::class);
    }

    public function connections()
    {
        return $this->hasMany(ConnectionLog::class);
    }
}
