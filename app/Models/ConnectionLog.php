<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConnectionLog extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'playlist_id',
        'ip_address',
        'user_agent',
        'country',
        'city',
        'isp',
        'is_vpn',
        'connected_at',
        'disconnected_at',
    ];

    protected $casts = [
        'is_vpn' => 'boolean',
        'connected_at' => 'datetime',
        'disconnected_at' => 'datetime',
    ];

    public function playlist()
    {
        return $this->belongsTo(Playlist::class);
    }
}
